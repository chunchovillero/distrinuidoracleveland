<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Seller;
use App\Models\Customer;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SalesDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener todos los vendedores (sellers)
        $sellers = Seller::where('active', true)->get();
        $customers = Customer::all();
        $products = Product::where('active', true)->get();

        if ($sellers->isEmpty() || $customers->isEmpty() || $products->isEmpty()) {
            $this->command->error('No hay suficientes vendedores, clientes o productos para generar ventas.');
            return;
        }

        // Generar 100 ventas distribuidas en 2025
        $startDate = Carbon::create(2025, 1, 1);
        $endDate = Carbon::create(2025, 11, 5); // Hasta hoy

        $salesData = [];
        $saleDetailsData = [];
        $invoiceCounter = 1001;

        for ($i = 1; $i <= 100; $i++) {
            // Fecha aleatoria dentro del rango
            $saleDate = $startDate->copy()->addDays(rand(0, $startDate->diffInDays($endDate)));
            
            // Seleccionar vendedor y cliente aleatorio
            $seller = $sellers->random();
            $customer = $customers->random();
            
            // Generar número de venta único
            $invoiceNumber = 'VTA-' . str_pad($invoiceCounter++, 6, '0', STR_PAD_LEFT);
            
            // Seleccionar productos aleatorios (entre 1 y 5 productos por venta)
            $selectedProducts = $products->random(rand(1, 5));
            
            $subtotal = 0;
            $currentSaleDetails = [];
            
            foreach ($selectedProducts as $product) {
                $quantity = rand(1, 10);
                $unitPrice = $product->price;
                $productSubtotal = $quantity * $unitPrice;
                $subtotal += $productSubtotal;
                
                $currentSaleDetails[] = [
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $productSubtotal,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            
            // Calcular impuestos y total
            $tax = $subtotal * 0.19; // 19% IVA
            $total = $subtotal + $tax;
            
            // Calcular comisión (entre 5% y 15% del total)
            $commissionPercentage = rand(5, 15);
            $totalCommission = $total * ($commissionPercentage / 100);
            
            // Determinar método de pago aleatorio
            $paymentMethods = ['cash', 'card', 'transfer'];
            $paymentMethod = $paymentMethods[array_rand($paymentMethods)];
            
            // Determinar estado (la mayoría completadas)
            $statuses = ['completed', 'completed', 'completed', 'completed', 'pending'];
            $status = $statuses[array_rand($statuses)];
            
            // Obtener el próximo ID disponible
            $maxId = DB::table('sales')->max('id') ?? 0;
            $saleId = $maxId + $i;
            
            $salesData[] = [
                'id' => $saleId,
                'invoice_number' => $invoiceNumber,
                'customer_id' => $customer->id,
                'seller_id' => $seller->id,
                'sale_date' => $saleDate,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'total_commission' => $totalCommission,
                'payment_method' => $paymentMethod,
                'status' => $status,
                'notes' => $this->generateRandomNote(),
                'created_at' => $saleDate,
                'updated_at' => $saleDate,
            ];
            
            // Agregar sale_id a los detalles
            foreach ($currentSaleDetails as &$detail) {
                $detail['sale_id'] = $saleId;
            }
            
            $saleDetailsData = array_merge($saleDetailsData, $currentSaleDetails);
        }

        // Insertar todas las ventas
        DB::table('sales')->insert($salesData);
        
        // Insertar todos los detalles de venta
        DB::table('sale_details')->insert($saleDetailsData);

        $this->command->info('100 ventas distribuidas en 2025 creadas exitosamente.');
        $this->command->info('Total de ventas: $' . number_format(array_sum(array_column($salesData, 'total')), 0, ',', '.'));
        $this->command->info('Total de comisiones: $' . number_format(array_sum(array_column($salesData, 'total_commission')), 0, ',', '.'));
    }

    /**
     * Generar nota aleatoria para la venta
     */
    private function generateRandomNote(): ?string
    {
        $notes = [
            'Venta realizada en tienda',
            'Cliente frecuente - descuento aplicado',
            'Pago en efectivo',
            'Producto con garantía extendida',
            'Cliente satisfecho con la atención',
            'Venta por recomendación',
            'Promoción especial aplicada',
            null, // Algunas ventas sin notas
            null,
            'Entrega a domicilio solicitada',
        ];
        
        return $notes[array_rand($notes)];
    }
}