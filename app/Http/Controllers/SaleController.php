<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Customer;
use App\Models\Seller;
use App\Models\Product;
use App\Models\SaleDetail;
use App\Models\ExportConfiguration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Sale::with(['customer', 'seller']);
        
        // Filtro por rango de fechas
        if ($request->filled('date_from')) {
            $query->where('sale_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->where('sale_date', '<=', $request->date_to);
        }
        
        // Filtro por últimos días
        if ($request->filled('last_days')) {
            $query->where('sale_date', '>=', now()->subDays($request->last_days));
        }
        
        // Filtro por vendedor
        if ($request->filled('seller_id')) {
            $query->where('seller_id', $request->seller_id);
        }
        
        // Filtro por cliente
        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }
        
        // Filtro por estado
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $sales = $query->latest('sale_date')->get();
        
        // Datos para los filtros
        $sellers = Seller::where('active', true)->get();
        $customers = Customer::where('active', true)->get();
        
        return view('sales.index', compact('sales', 'sellers', 'customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::where('active', true)->get();
        $sellers = Seller::where('active', true)->get();
        $products = Product::where('active', true)->where('stock', '>', 0)->get();
        
        return view('sales.create', compact('customers', 'sellers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'seller_id' => 'required|exists:sellers,id',
            'sale_date' => 'required|date',
            'payment_method' => 'required|in:cash,card,transfer,check',
            'notes' => 'nullable',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();
        try {
            // Crear la venta
            $sale = Sale::create([
                'invoice_number' => Sale::generateInvoiceNumber(),
                'customer_id' => $request->customer_id,
                'seller_id' => $request->seller_id,
                'sale_date' => $request->sale_date,
                'payment_method' => $request->payment_method,
                'notes' => $request->notes,
                'subtotal' => 0,
                'tax' => 0,
                'total' => 0,
                'total_commission' => 0,
                'status' => 'completed'
            ]);

            $subtotal = 0;
            $totalCommission = 0;

            // Procesar cada producto
            foreach ($request->products as $productData) {
                $product = Product::findOrFail($productData['id']);
                
                // Verificar stock disponible
                if ($product->stock < $productData['quantity']) {
                    throw new \Exception("Stock insuficiente para el producto: {$product->name}");
                }

                // Crear detalle de venta
                $subtotalDetail = $product->price * $productData['quantity'];
                $commissionAmount = ($subtotalDetail * $product->commission) / 100;
                
                $saleDetail = SaleDetail::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $productData['quantity'],
                    'unit_price' => $product->price,
                    'commission_percentage' => $product->commission,
                    'commission_amount' => $commissionAmount,
                    'subtotal' => $subtotalDetail
                ]);

                // Reducir stock del producto
                $product->reduceStock($productData['quantity']);

                $subtotal += $saleDetail->subtotal;
                $totalCommission += $saleDetail->commission_amount;
            }

            // Actualizar totales de la venta
            $sale->update([
                'subtotal' => $subtotal,
                'total' => $subtotal,
                'total_commission' => $totalCommission
            ]);

            DB::commit();
            return redirect()->route('admin.sales.show', $sale)->with('success', 'Venta creada exitosamente.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error al crear la venta: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        $sale->load(['customer', 'seller', 'saleDetails.product']);
        return view('sales.show', compact('sale'));
    }

    /**
     * Duplicate a sale for the same customer
     */
    public function duplicate(Sale $sale)
    {
        $customers = Customer::where('active', true)->get();
        $sellers = Seller::where('active', true)->get();
        $products = Product::where('active', true)->where('stock', '>', 0)->get();
        
        // Obtener los productos de la venta original
        $originalProducts = $sale->saleDetails()->with('product')->get();
        
        return view('sales.create', compact('customers', 'sellers', 'products', 'sale', 'originalProducts'));
    }

    /**
     * Cancel a sale
     */
    public function cancel(Sale $sale)
    {
        if ($sale->status === 'cancelled') {
            return redirect()->back()->with('error', 'La venta ya está cancelada.');
        }

        DB::beginTransaction();
        try {
            // Restaurar stock de los productos
            foreach ($sale->saleDetails as $detail) {
                $detail->product->addStock($detail->quantity);
            }

            // Cambiar estado de la venta
            $sale->update(['status' => 'cancelled']);

            DB::commit();
            return redirect()->route('admin.sales.index')->with('success', 'Venta cancelada exitosamente.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error al cancelar la venta: ' . $e->getMessage());
        }
    }

    /**
     * Get product details for AJAX
     */
    public function getProductDetails($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return response()->json($product);
    }

    /**
     * Show export configuration modal
     */
    public function showExportConfig(Request $request)
    {
        try {
            $exportType = $request->get('type'); // 'despacho' o 'secretaria'
            $filters = $request->except('type');
            
            // Log para debug
            \Log::info('Export config request', ['type' => $exportType, 'filters' => $filters]);
            
            // Configuraciones predefinidas
            $defaultFields = [
                'despacho' => [
                    'invoice_number' => 'Número de Venta',
                    'customer_name' => 'Cliente',
                    'customer_phone' => 'Teléfono Cliente',
                    'customer_address' => 'Dirección Cliente',
                    'sale_date' => 'Fecha de Venta',
                    'products' => 'Productos',
                    'quantities' => 'Cantidades',
                    'products_detailed' => 'Productos Detallado',
                    'total' => 'Total'
                ],
                'secretaria' => [
                    'invoice_number' => 'Número de Venta',
                    'customer_name' => 'Cliente',
                    'customer_document' => 'Documento Cliente',
                    'seller_name' => 'Vendedor',
                    'sale_date' => 'Fecha de Venta',
                    'payment_method' => 'Método de Pago',
                    'products' => 'Productos',
                    'quantities' => 'Cantidades',
                    'products_detailed' => 'Productos Detallado',
                    'subtotal' => 'Subtotal',
                    'total' => 'Total',
                    'total_commission' => 'Comisión Total',
                    'status' => 'Estado',
                    'notes' => 'Notas'
                ]
            ];
            
            $availableFields = $defaultFields[$exportType] ?? $defaultFields['secretaria'];
            
            // Buscar configuración guardada
            $savedConfig = ExportConfiguration::getDefaultConfiguration($exportType);
            $selectedFields = $savedConfig ? $savedConfig->selected_fields : array_keys($availableFields);
            
            return response()->json([
                'success' => true,
                'fields' => $availableFields,
                'selectedFields' => $selectedFields,
                'type' => $exportType,
                'filters' => $filters,
                'hasConfig' => $savedConfig !== null
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error in showExportConfig', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar configuración: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export sales to Excel
     */
    public function exportSales(Request $request)
    {
        try {
            $exportType = $request->get('export_type');
            $selectedFields = $request->get('fields', []);
            $filters = $request->except(['export_type', 'fields', '_token']);
            
            // Construir query con filtros
            $query = Sale::with(['customer', 'seller', 'saleDetails.product']);
            
            if (!empty($filters['date_from'])) {
                $query->where('sale_date', '>=', $filters['date_from']);
            }
            
            if (!empty($filters['date_to'])) {
                $query->where('sale_date', '<=', $filters['date_to']);
            }
            
            if (!empty($filters['last_days'])) {
                $query->where('sale_date', '>=', now()->subDays($filters['last_days']));
            }
            
            if (!empty($filters['seller_id'])) {
                $query->where('seller_id', $filters['seller_id']);
            }
            
            if (!empty($filters['customer_id'])) {
                $query->where('customer_id', $filters['customer_id']);
            }
            
            if (!empty($filters['status'])) {
                $query->where('status', $filters['status']);
            }
            
            $sales = $query->latest('sale_date')->get();
            
            // Crear nuevo archivo Excel
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Configurar título del reporte
            $sheet->setTitle('Ventas ' . ucfirst($exportType));
            
            // Labels de campos
            $fieldLabels = [
                'invoice_number' => 'Número de Venta',
                'customer_name' => 'Cliente',
                'customer_document' => 'Documento Cliente',
                'customer_phone' => 'Teléfono Cliente',
                'customer_address' => 'Dirección Cliente',
                'seller_name' => 'Vendedor',
                'sale_date' => 'Fecha de Venta',
                'payment_method' => 'Método de Pago',
                'subtotal' => 'Subtotal',
                'total' => 'Total',
                'total_commission' => 'Comisión Total',
                'status' => 'Estado',
                'notes' => 'Notas',
                'products' => 'Productos',
                'quantities' => 'Cantidades',
                'products_detailed' => 'Producto',
                'product_quantity' => 'Cantidad',
                'product_price' => 'Precio Unit.',
                'product_commission' => 'Comisión'
            ];
            
            // Verificar si se seleccionó modo detallado
            $detailedMode = in_array('products_detailed', $selectedFields);
            
            // Si está en modo detallado, remover products y quantities, y agregar columnas de detalle
            if ($detailedMode) {
                $selectedFields = array_filter($selectedFields, function($field) {
                    return !in_array($field, ['products', 'quantities', 'products_detailed']);
                });
                // Agregar columnas de productos detallados
                $selectedFields = array_merge($selectedFields, ['products_detailed', 'product_quantity', 'product_price', 'product_commission']);
            }
            
            // Crear título del reporte
            $sheet->setCellValue('A1', 'REPORTE DE VENTAS - ' . strtoupper($exportType));
            $sheet->mergeCells('A1:' . chr(64 + count($selectedFields)) . '1');
            
            // Información del reporte
            $sheet->setCellValue('A2', 'Fecha de generación: ' . now()->format('d/m/Y H:i'));
            $sheet->setCellValue('A3', 'Total de registros: ' . $sales->count());
            
            // Aplicar estilos al encabezado
            $sheet->getStyle('A1')->applyFromArray([
                'font' => [
                    'bold' => true,
                    'size' => 16,
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'color' => ['rgb' => '366092']
                ]
            ]);
            
            // Headers de columnas (fila 5)
            $column = 'A';
            foreach ($selectedFields as $field) {
                $sheet->setCellValue($column . '5', $fieldLabels[$field] ?? $field);
                $column++;
            }
            
            // Aplicar estilos a los headers
            $lastColumn = chr(64 + count($selectedFields));
            $sheet->getStyle('A5:' . $lastColumn . '5')->applyFromArray([
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'color' => ['rgb' => '4472C4']
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000']
                    ]
                ]
            ]);
            
            // Llenar datos
            $row = 6;
            foreach ($sales as $sale) {
                if ($detailedMode) {
                    // Modo detallado: una fila por cada producto de la venta
                    foreach ($sale->saleDetails as $index => $detail) {
                        $column = 'A';
                        foreach ($selectedFields as $field) {
                            $value = '';
                            switch ($field) {
                                case 'invoice_number':
                                    // Solo mostrar el número de venta en la primera fila del detalle
                                    $value = $index === 0 ? $sale->invoice_number : '';
                                    break;
                                case 'customer_name':
                                    $value = $index === 0 ? $sale->customer->name : '';
                                    break;
                                case 'customer_document':
                                    $value = $index === 0 ? $sale->customer->document_type . ' ' . $sale->customer->document_number : '';
                                    break;
                                case 'customer_phone':
                                    $value = $index === 0 ? $sale->customer->phone : '';
                                    break;
                                case 'customer_address':
                                    $value = $index === 0 ? $sale->customer->address : '';
                                    break;
                                case 'seller_name':
                                    $value = $index === 0 ? $sale->seller->name : '';
                                    break;
                                case 'sale_date':
                                    $value = $index === 0 ? $sale->sale_date->format('d/m/Y') : '';
                                    break;
                                case 'payment_method':
                                    if ($index === 0) {
                                        $methods = [
                                            'cash' => 'Efectivo',
                                            'card' => 'Tarjeta',
                                            'transfer' => 'Transferencia',
                                            'check' => 'Cheque'
                                        ];
                                        $value = $methods[$sale->payment_method] ?? $sale->payment_method;
                                    }
                                    break;
                                case 'subtotal':
                                    $value = $index === 0 ? $sale->subtotal : '';
                                    break;
                                case 'total':
                                    $value = $index === 0 ? $sale->total : '';
                                    break;
                                case 'total_commission':
                                    $value = $index === 0 ? $sale->total_commission : '';
                                    break;
                                case 'status':
                                    if ($index === 0) {
                                        $statuses = [
                                            'completed' => 'Completada',
                                            'pending' => 'Pendiente',
                                            'cancelled' => 'Cancelada'
                                        ];
                                        $value = $statuses[$sale->status] ?? $sale->status;
                                    }
                                    break;
                                case 'notes':
                                    $value = $index === 0 ? $sale->notes : '';
                                    break;
                                case 'products_detailed':
                                    $value = $detail->product->name;
                                    break;
                                case 'product_quantity':
                                    $value = $detail->quantity;
                                    break;
                                case 'product_price':
                                    $value = $detail->unit_price;
                                    break;
                                case 'product_commission':
                                    $value = $detail->commission_amount;
                                    break;
                            }
                            
                            $sheet->setCellValue($column . $row, $value);
                            
                            // Formatear números como moneda
                            if (in_array($field, ['subtotal', 'total', 'total_commission', 'product_price', 'product_commission'])) {
                                $sheet->getStyle($column . $row)->getNumberFormat()->setFormatCode('_("$"* #,##0_);_("$"* \(#,##0\);_("$"* "-"??_);_(@_)');
                            }
                            
                            $column++;
                        }
                        $row++;
                    }
                } else {
                    // Modo normal: una fila por venta
                    $column = 'A';
                    foreach ($selectedFields as $field) {
                        $value = '';
                        switch ($field) {
                            case 'invoice_number':
                                $value = $sale->invoice_number;
                                break;
                            case 'customer_name':
                                $value = $sale->customer->name;
                                break;
                            case 'customer_document':
                                $value = $sale->customer->document_type . ' ' . $sale->customer->document_number;
                                break;
                            case 'customer_phone':
                                $value = $sale->customer->phone;
                                break;
                            case 'customer_address':
                                $value = $sale->customer->address;
                                break;
                            case 'seller_name':
                                $value = $sale->seller->name;
                                break;
                            case 'sale_date':
                                $value = $sale->sale_date->format('d/m/Y');
                                break;
                            case 'payment_method':
                                $methods = [
                                    'cash' => 'Efectivo',
                                    'card' => 'Tarjeta',
                                    'transfer' => 'Transferencia',
                                    'check' => 'Cheque'
                                ];
                                $value = $methods[$sale->payment_method] ?? $sale->payment_method;
                                break;
                            case 'subtotal':
                                $value = $sale->subtotal;
                                break;
                            case 'total':
                                $value = $sale->total;
                                break;
                            case 'total_commission':
                                $value = $sale->total_commission;
                                break;
                            case 'status':
                                $statuses = [
                                    'completed' => 'Completada',
                                    'pending' => 'Pendiente',
                                    'cancelled' => 'Cancelada'
                                ];
                                $value = $statuses[$sale->status] ?? $sale->status;
                                break;
                            case 'notes':
                                $value = $sale->notes;
                                break;
                            case 'products':
                                $value = $sale->saleDetails->pluck('product.name')->join(', ');
                                break;
                            case 'quantities':
                                $value = $sale->saleDetails->pluck('quantity')->join(', ');
                                break;
                        }
                        
                        $sheet->setCellValue($column . $row, $value);
                        
                        // Formatear números como moneda
                        if (in_array($field, ['subtotal', 'total', 'total_commission'])) {
                            $sheet->getStyle($column . $row)->getNumberFormat()->setFormatCode('_("$"* #,##0_);_("$"* \(#,##0\);_("$"* "-"??_);_(@_)');
                        }
                        
                        $column++;
                    }
                    $row++;
                }
            }
            
            // Aplicar bordes a toda la tabla de datos
            $dataRange = 'A5:' . $lastColumn . ($row - 1);
            $sheet->getStyle($dataRange)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000']
                    ]
                ]
            ]);
            
            // Ajustar ancho de columnas
            foreach (range('A', $lastColumn) as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
            
            // Crear writer y generar archivo
            $writer = new Xlsx($spreadsheet);
            
            $filename = 'ventas_' . $exportType . '_' . date('Y-m-d_H-i-s') . '.xlsx';
            
            // Limpiar cualquier salida anterior
            if (ob_get_level()) {
                ob_end_clean();
            }
            
            // Configurar headers para la descarga
            return response()->streamDownload(function () use ($writer) {
                $writer->save('php://output');
            }, $filename, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Cache-Control' => 'max-age=0',
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error in exportSales', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Error al exportar: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        if ($sale->status === 'completed') {
            return redirect()->back()->with('error', 'No se puede eliminar una venta completada. Debe cancelarla primero.');
        }

        DB::beginTransaction();
        try {
            // Restaurar stock si la venta no está cancelada
            if ($sale->status !== 'cancelled') {
                foreach ($sale->saleDetails as $detail) {
                    $detail->product->addStock($detail->quantity);
                }
            }

            // Eliminar detalles de venta
            $sale->saleDetails()->delete();
            
            // Eliminar venta
            $sale->delete();

            DB::commit();
            return redirect()->route('admin.sales.index')->with('success', 'Venta eliminada exitosamente.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error al eliminar la venta: ' . $e->getMessage());
        }
    }

    /**
     * Save export configuration
     */
    public function saveExportConfig(Request $request)
    {
        try {
            $exportType = $request->get('export_type');
            $selectedFields = $request->get('fields', []);
            
            // Eliminar configuración anterior si existe
            ExportConfiguration::where('export_type', $exportType)->delete();
            
            // Crear nueva configuración
            $config = ExportConfiguration::create([
                'export_type' => $exportType,
                'selected_fields' => $selectedFields,
                'is_default' => true
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Configuración guardada exitosamente'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error saving export config', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar configuración: ' . $e->getMessage()
            ], 500);
        }
    }
}
