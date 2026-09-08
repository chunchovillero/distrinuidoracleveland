<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Seller;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Dashboard principal con reportes generales
     */
    public function index()
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        
        // Ventas de hoy
        $todaySales = Sale::whereDate('sale_date', $today)->sum('total');
        
        // Ventas del mes
        $monthSales = Sale::whereBetween('sale_date', [$startOfMonth, Carbon::now()])->sum('total');
        
        // Total de productos activos
        $totalProducts = Product::where('active', true)->count();
        
        // Productos con stock bajo (menos de 10)
        $lowStockProducts = Product::where('stock', '<', 10)->where('active', true)->count();
        
        // Ventas por vendedor este mes
        $sellerSales = Sale::with('seller')
            ->whereBetween('sale_date', [$startOfMonth, Carbon::now()])
            ->get()
            ->groupBy('seller_id')
            ->map(function ($sales) {
                $totalSales = $sales->sum('total');
                $totalCommission = $sales->sum(function($sale) {
                    return $totalSales * ($sale->seller->commission_percentage / 100);
                });
                
                return [
                    'name' => $sales->first()->seller->name,
                    'total_sales' => $totalSales,
                    'sales_count' => $sales->count(),
                    'total_commission' => $totalCommission
                ];
            })
            ->sortByDesc('total_sales');
        
        // Productos más vendidos este mes
        $topProducts = DB::table('sale_details')
            ->join('sales', 'sale_details.sale_id', '=', 'sales.id')
            ->join('products', 'sale_details.product_id', '=', 'products.id')
            ->whereBetween('sales.sale_date', [$startOfMonth, Carbon::now()])
            ->select(
                'products.name',
                DB::raw('SUM(sale_details.quantity) as quantity_sold'),
                DB::raw('SUM(sale_details.quantity * sale_details.unit_price) as total_revenue')
            )
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('quantity_sold')
            ->get();
        
        return view('reports.index', compact(
            'todaySales', 
            'monthSales', 
            'totalProducts', 
            'lowStockProducts',
            'sellerSales',
            'topProducts'
        ));
    }

    /**
     * Reporte de ventas por fechas
     */
    public function salesReport(Request $request)
    {
        $dateFrom = $request->get('date_from', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', Carbon::now()->format('Y-m-d'));
        $sellerId = $request->get('seller_id');

        $query = Sale::with(['customer', 'seller', 'saleDetails.product'])
                    ->whereBetween('sale_date', [$dateFrom, $dateTo])
                    ->where('status', 'completed');

        if ($sellerId) {
            $query->where('seller_id', $sellerId);
        }

        $sales = $query->latest('sale_date')->get();
        $totalSales = $sales->count();
        $totalAmount = $sales->sum('total');
        $totalCommissions = $sales->sum('total_commission');
        $averageSale = $totalSales > 0 ? $totalAmount / $totalSales : 0;

        // Ventas por día para el gráfico
        $dailySales = Sale::selectRaw('DATE(sale_date) as date, SUM(total) as total')
                         ->whereBetween('sale_date', [$dateFrom, $dateTo])
                         ->where('status', 'completed')
                         ->when($sellerId, function($q) use ($sellerId) {
                             return $q->where('seller_id', $sellerId);
                         })
                         ->groupBy('date')
                         ->orderBy('date')
                         ->get()
                         ->map(function($item) {
                             return [
                                 'date' => Carbon::parse($item->date)->format('d/m'),
                                 'total' => $item->total
                             ];
                         });

        // Top vendedores
        $topSellers = Seller::with(['sales' => function($q) use ($dateFrom, $dateTo) {
                                $q->whereBetween('sale_date', [$dateFrom, $dateTo])
                                  ->where('status', 'completed');
                            }])
                            ->get()
                            ->map(function($seller) {
                                return [
                                    'name' => $seller->name,
                                    'sales_count' => $seller->sales->count(),
                                    'total_amount' => $seller->sales->sum('total'),
                                    'total_commission' => $seller->sales->sum('total_commission')
                                ];
                            })
                            ->filter(function($item) {
                                return $item['sales_count'] > 0;
                            })
                            ->sortByDesc('total_amount')
                            ->take(5)
                            ->values();

        // Top productos
        $topProducts = Product::with(['saleDetails' => function($q) use ($dateFrom, $dateTo) {
                                 $q->whereHas('sale', function($query) use ($dateFrom, $dateTo) {
                                     $query->whereBetween('sale_date', [$dateFrom, $dateTo])
                                           ->where('status', 'completed');
                                 });
                             }])
                             ->get()
                             ->map(function($product) {
                                 return [
                                     'name' => $product->name,
                                     'total_quantity' => $product->saleDetails->sum('quantity'),
                                     'total_amount' => $product->saleDetails->sum('subtotal')
                                 ];
                             })
                             ->filter(function($item) {
                                 return $item['total_quantity'] > 0;
                             })
                             ->sortByDesc('total_quantity')
                             ->take(5)
                             ->values();

        $sellers = Seller::where('active', true)->get();

        return view('reports.sales', compact(
            'sales', 'totalSales', 'totalAmount', 'totalCommissions', 'averageSale',
            'dailySales', 'topSellers', 'topProducts', 'sellers',
            'dateFrom', 'dateTo', 'sellerId'
        ));
    }

    /**
     * Reporte de comisiones por vendedor
     */
    public function commissionsReport(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        $sellers = Seller::with(['sales' => function($query) use ($startDate, $endDate) {
            $query->whereBetween('sale_date', [$startDate, $endDate])
                  ->where('status', 'completed');
        }])->get()->map(function($seller) {
            $totalSales = $seller->sales->sum('total');
            $totalCommission = $seller->sales->sum('total_commission');
            $salesCount = $seller->sales->count();

            return [
                'id' => $seller->id,
                'name' => $seller->name,
                'email' => $seller->email,
                'total_sales' => $totalSales,
                'total_commission' => $totalCommission,
                'sales_count' => $salesCount,
                'average_sale' => $salesCount > 0 ? $totalSales / $salesCount : 0
            ];
        })->sortByDesc('total_commission')->values();

        return view('reports.commissions', compact('sellers', 'startDate', 'endDate'));
    }

    /**
     * Reporte de inventario
     */
    public function inventoryReport()
    {
        $products = Product::with('category')
                          ->where('active', true)
                          ->get()
                          ->map(function($product) {
                              return [
                                  'id' => $product->id,
                                  'name' => $product->name,
                                  'sku' => $product->sku,
                                  'category' => $product->category->name,
                                  'stock' => $product->stock,
                                  'min_stock' => $product->min_stock,
                                  'price' => $product->price,
                                  'inventory_value' => $product->stock * $product->cost,
                                  'is_low_stock' => $product->isLowStock(),
                                  'status' => $product->stock == 0 ? 'Sin stock' : 
                                            ($product->isLowStock() ? 'Stock bajo' : 'Normal')
                              ];
                          });

        $totalValue = $products->sum('inventory_value');
        $lowStockCount = $products->where('is_low_stock', true)->count();
        $outOfStockCount = $products->where('stock', 0)->count();

        return view('reports.inventory', compact('products', 'totalValue', 'lowStockCount', 'outOfStockCount'));
    }

    /**
     * Reporte de clientes top
     */
    public function customersReport(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfYear()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        $customers = Customer::with(['sales' => function($query) use ($startDate, $endDate) {
            $query->whereBetween('sale_date', [$startDate, $endDate])
                  ->where('status', 'completed');
        }])->get()->map(function($customer) {
            $totalPurchases = $customer->sales->sum('total');
            $purchaseCount = $customer->sales->count();
            $lastPurchase = $customer->sales->max('sale_date');

            return [
                'id' => $customer->id,
                'name' => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->phone,
                'total_purchases' => $totalPurchases,
                'purchase_count' => $purchaseCount,
                'average_purchase' => $purchaseCount > 0 ? $totalPurchases / $purchaseCount : 0,
                'last_purchase' => $lastPurchase
            ];
        })->filter(function($item) {
            return $item['purchase_count'] > 0;
        })->sortByDesc('total_purchases')->values();

        return view('reports.customers', compact('customers', 'startDate', 'endDate'));
    }

    /**
     * Reporte mensual de los últimos 12 meses
     */
    public function monthlyReport()
    {
        // Obtener los últimos 12 meses (del más reciente al más antiguo)
        $months = collect();
        for ($i = 0; $i < 12; $i++) {
            $month = Carbon::now()->subMonths($i);
            $months->push([
                'year' => $month->year,
                'month' => $month->month,
                'month_name' => $month->locale('es')->translatedFormat('F Y'),
                'start_date' => $month->startOfMonth()->toDateString(),
                'end_date' => $month->endOfMonth()->toDateString()
            ]);
        }

        // Obtener datos de ventas por mes
        $monthlyData = $months->map(function($monthInfo) {
            $sales = Sale::whereBetween('sale_date', [$monthInfo['start_date'], $monthInfo['end_date']])
                        ->where('status', 'completed')
                        ->get();

            $totalSales = $sales->sum('total');
            $salesCount = $sales->count();
            $totalCommissions = $sales->sum('total_commission');
            $averageSale = $salesCount > 0 ? $totalSales / $salesCount : 0;

            // Top vendedor del mes
            $topSeller = $sales->groupBy('seller_id')
                             ->map(function($sellerSales) {
                                 $firstSale = $sellerSales->first();
                                 return [
                                     'name' => $firstSale->seller->name ?? 'N/A',
                                     'total' => $sellerSales->sum('total'),
                                     'count' => $sellerSales->count()
                                 ];
                             })
                             ->sortByDesc('total')
                             ->first();

            // Productos más vendidos del mes
            $topProduct = DB::table('sale_details')
                           ->join('sales', 'sale_details.sale_id', '=', 'sales.id')
                           ->join('products', 'sale_details.product_id', '=', 'products.id')
                           ->whereBetween('sales.sale_date', [$monthInfo['start_date'], $monthInfo['end_date']])
                           ->where('sales.status', 'completed')
                           ->select(
                               'products.name',
                               DB::raw('SUM(sale_details.quantity) as quantity_sold')
                           )
                           ->groupBy('products.id', 'products.name')
                           ->orderByDesc('quantity_sold')
                           ->first();

            return [
                'month' => $monthInfo['month_name'],
                'month_short' => Carbon::createFromDate($monthInfo['year'], $monthInfo['month'], 1)->locale('es')->translatedFormat('M'),
                'year' => $monthInfo['year'],
                'total_sales' => $totalSales,
                'sales_count' => $salesCount,
                'total_commissions' => $totalCommissions,
                'average_sale' => $averageSale,
                'top_seller' => $topSeller,
                'top_product' => $topProduct
            ];
        });

        // Datos para gráficos (orden cronológico: más antiguo a más reciente)
        $chartData = [
            'labels' => $monthlyData->reverse()->pluck('month_short')->toArray(),
            'sales' => $monthlyData->reverse()->pluck('total_sales')->toArray(),
            'count' => $monthlyData->reverse()->pluck('sales_count')->toArray(),
            'commissions' => $monthlyData->reverse()->pluck('total_commissions')->toArray()
        ];

        // Estadísticas generales
        $totalYear = $monthlyData->sum('total_sales');
        $totalSalesCount = $monthlyData->sum('sales_count');
        $totalCommissionsYear = $monthlyData->sum('total_commissions');
        $averageMonthly = $totalYear / 12;

        // Mejor y peor mes
        $bestMonth = $monthlyData->sortByDesc('total_sales')->first();
        $worstMonth = $monthlyData->where('total_sales', '>', 0)->sortBy('total_sales')->first();

        return view('reports.monthly', compact(
            'monthlyData', 
            'chartData', 
            'totalYear', 
            'totalSalesCount', 
            'totalCommissionsYear', 
            'averageMonthly',
            'bestMonth',
            'worstMonth'
        ));
    }

    /**
     * Reporte de productos por calidad
     */
    public function calidadReport()
    {
        // Estadísticas generales
        $totalProducts = Product::count();
        $productsWithCalidad = Product::whereNotNull('calidad_id')->count();
        $productsWithoutCalidad = $totalProducts - $productsWithCalidad;

        // Productos por calidad
        $productsByCalidad = \App\Models\Calidad::withCount('products')
            ->with(['products' => function($query) {
                $query->select('calidad_id', 'stock', 'price')
                      ->selectRaw('SUM(stock) as total_stock')
                      ->selectRaw('SUM(stock * price) as total_value')
                      ->groupBy('calidad_id');
            }])
            ->get();

        // Datos para el gráfico de distribución
        $chartData = [];
        $chartLabels = [];
        $chartColors = ['#007bff', '#28a745', '#ffc107', '#dc3545', '#6c757d'];

        foreach ($productsByCalidad as $index => $calidad) {
            $chartLabels[] = $calidad->nombre;
            $chartData[] = $calidad->products_count;
        }

        // Si hay productos sin calidad, agregarlos
        if ($productsWithoutCalidad > 0) {
            $chartLabels[] = 'Sin Calidad';
            $chartData[] = $productsWithoutCalidad;
        }

        // Top 5 productos más valiosos por calidad
        $topProducts = Product::with(['calidad', 'category'])
            ->selectRaw('*, (stock * price) as total_value')
            ->orderBy('total_value', 'desc')
            ->limit(10)
            ->get();

        // Stock total y valor por calidad
        $stockByCalidad = Product::select('calidad_id')
            ->selectRaw('COUNT(*) as count')
            ->selectRaw('SUM(stock) as total_stock')
            ->selectRaw('SUM(stock * price) as total_value')
            ->selectRaw('AVG(price) as avg_price')
            ->with('calidad')
            ->whereNotNull('calidad_id')
            ->groupBy('calidad_id')
            ->get();

        // Productos con stock bajo por calidad
        $lowStockByCalidad = Product::whereRaw('stock <= min_stock')
            ->with('calidad')
            ->get()
            ->groupBy('calidad.nombre');

        return view('reports.calidad', compact(
            'totalProducts',
            'productsWithCalidad', 
            'productsWithoutCalidad',
            'productsByCalidad',
            'chartData',
            'chartLabels',
            'chartColors',
            'topProducts',
            'stockByCalidad',
            'lowStockByCalidad'
        ));
    }
}
