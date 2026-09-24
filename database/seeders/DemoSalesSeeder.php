<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Seller;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class DemoSalesSeeder extends Seeder
{
    private const SALES_TO_CREATE = 100;

    public function run(): void
    {
        $this->ensureDemoCustomers();
        $this->ensureDemoSellers();

        $customers = Customer::where('active', true)->get();
        $sellers = Seller::where('active', true)->get();

        if ($customers->count() < 2 || $sellers->count() < 2) {
            throw new RuntimeException('Se necesitan al menos dos clientes y dos vendedores activos.');
        }

        $batch = now()->format('YmdHis');
        $created = 0;
        $grandTotal = 0;
        $grandCommission = 0;

        DB::transaction(function () use (
            $customers,
            $sellers,
            $batch,
            &$created,
            &$grandTotal,
            &$grandCommission
        ): void {
            for ($number = 1; $number <= self::SALES_TO_CREATE; $number++) {
                $availableProducts = Product::where('active', true)
                    ->where('stock', '>', 0)
                    ->inRandomOrder()
                    ->limit(random_int(1, 4))
                    ->lockForUpdate()
                    ->get();

                if ($availableProducts->isEmpty()) {
                    throw new RuntimeException("No queda stock para completar la venta {$number}.");
                }

                $statusRoll = random_int(1, 100);
                $status = $statusRoll <= 90
                    ? 'completed'
                    : ($statusRoll <= 95 ? 'pending' : 'cancelled');

                $saleDate = Carbon::today()->subDays(random_int(0, 364));
                $customer = $customers->random();
                $seller = $sellers->random();

                $sale = Sale::create([
                    'invoice_number' => sprintf('DEMO-%s-%03d', $batch, $number),
                    'customer_id' => $customer->id,
                    'seller_id' => $seller->id,
                    'subtotal' => 0,
                    'tax' => 0,
                    'total' => 0,
                    'total_commission' => 0,
                    'payment_method' => collect(['cash', 'card', 'transfer', 'check'])->random(),
                    'notes' => 'Venta de demostración generada automáticamente',
                    'status' => $status,
                    'sale_date' => $saleDate,
                ]);

                $subtotal = 0;
                $commission = 0;

                foreach ($availableProducts as $product) {
                    $quantity = random_int(1, min(3, (int) $product->stock));
                    $lineSubtotal = (float) $product->price * $quantity;
                    $lineCommission = (float) $product->commission * $quantity;

                    SaleDetail::create([
                        'sale_id' => $sale->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'unit_price' => $product->price,
                        'commission_unit_price' => $product->commission,
                        'commission_percentage' => 0,
                        'commission_amount' => round($lineCommission, 2),
                        'subtotal' => round($lineSubtotal, 2),
                    ]);

                    // Una venta cancelada no debe modificar el inventario.
                    if ($status !== 'cancelled') {
                        $product->decrement('stock', $quantity);
                    }

                    $subtotal += $lineSubtotal;
                    $commission += $lineCommission;
                }

                $sale->update([
                    'subtotal' => round($subtotal, 2),
                    'total' => round($subtotal, 2),
                    'total_commission' => round($commission, 2),
                ]);

                $created++;
                $grandTotal += $subtotal;
                $grandCommission += $commission;
            }
        });

        $this->command->info("{$created} ventas de demostración creadas exitosamente.");
        $this->command->line("Clientes utilizados: {$customers->count()}");
        $this->command->line("Vendedores utilizados: {$sellers->count()}");
        $this->command->line('Total vendido: $' . number_format($grandTotal, 0, ',', '.'));
        $this->command->line('Comisiones: $' . number_format($grandCommission, 0, ',', '.'));
    }

    private function ensureDemoCustomers(): void
    {
        $customers = [
            ['name' => 'Almacén Los Andes', 'rut' => '76.100.001-1', 'email' => 'losandes.demo@example.com'],
            ['name' => 'Comercial Santa María', 'rut' => '76.100.002-K', 'email' => 'santamaria.demo@example.com'],
            ['name' => 'Bazar Nueva Esperanza', 'rut' => '76.100.003-8', 'email' => 'esperanza.demo@example.com'],
            ['name' => 'Distribuidora El Faro', 'rut' => '76.100.004-6', 'email' => 'elfaro.demo@example.com'],
            ['name' => 'Tienda Central', 'rut' => '76.100.005-4', 'email' => 'central.demo@example.com'],
            ['name' => 'Comercial San Pedro', 'rut' => '76.100.006-2', 'email' => 'sanpedro.demo@example.com'],
            ['name' => 'Importadora del Sur', 'rut' => '76.100.007-0', 'email' => 'delsur.demo@example.com'],
            ['name' => 'Bodega La Estrella', 'rut' => '76.100.008-9', 'email' => 'estrella.demo@example.com'],
            ['name' => 'Mercado Cordillera', 'rut' => '76.100.009-7', 'email' => 'cordillera.demo@example.com'],
            ['name' => 'Comercial Pacífico', 'rut' => '76.100.010-0', 'email' => 'pacifico.demo@example.com'],
        ];

        foreach ($customers as $index => $customer) {
            Customer::firstOrCreate(
                ['email' => $customer['email']],
                $customer + [
                    'phone' => '+5695555' . str_pad((string) $index, 4, '0', STR_PAD_LEFT),
                    'address' => 'Dirección de demostración ' . ($index + 1),
                    'document_type' => 'RUT',
                    'document_number' => $customer['rut'],
                    'active' => true,
                ]
            );
        }
    }

    private function ensureDemoSellers(): void
    {
        $sellers = [
            ['name' => 'Sofía Martínez', 'email' => 'sofia.martinez.demo@example.com'],
            ['name' => 'Diego Rojas', 'email' => 'diego.rojas.demo@example.com'],
            ['name' => 'Camila González', 'email' => 'camila.gonzalez.demo@example.com'],
            ['name' => 'Matías Silva', 'email' => 'matias.silva.demo@example.com'],
            ['name' => 'Valentina Pérez', 'email' => 'valentina.perez.demo@example.com'],
        ];

        foreach ($sellers as $index => $seller) {
            Seller::firstOrCreate(
                ['email' => $seller['email']],
                $seller + [
                    'phone' => '+5694444' . str_pad((string) $index, 4, '0', STR_PAD_LEFT),
                    'address' => 'Sucursal de demostración ' . ($index + 1),
                    'active' => true,
                ]
            );
        }
    }
}
