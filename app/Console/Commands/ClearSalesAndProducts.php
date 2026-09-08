<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ClearSalesAndProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:clear-sales-products {--force : Omitir confirmación de seguridad} {--keep-images : Mantener imágenes de productos}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Elimina TODAS las ventas y productos de la base de datos (⚠️ IRREVERSIBLE ⚠️)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->warn('⚠️  ADVERTENCIA: OPERACIÓN DESTRUCTIVA ⚠️');
        $this->newLine();
        
        // Mostrar conteos actuales
        $ventasCount = Sale::count();
        $ventasDetallesCount = SaleDetail::count();
        $productosCount = Product::count();
        
        $this->info("📊 DATOS ACTUALES:");
        $this->info("• Ventas: {$ventasCount}");
        $this->info("• Detalles de venta: {$ventasDetallesCount}");
        $this->info("• Productos: {$productosCount}");
        $this->newLine();

        if ($ventasCount == 0 && $productosCount == 0) {
            $this->info('✅ No hay datos para eliminar.');
            return 0;
        }

        // Confirmación de seguridad si no se usa --force
        if (!$this->option('force')) {
            $this->error('🔥 ESTA OPERACIÓN ELIMINARÁ PERMANENTEMENTE:');
            $this->error("• {$ventasCount} ventas completas");
            $this->error("• {$ventasDetallesCount} detalles de venta");
            $this->error("• {$productosCount} productos");
            $this->error('• Imágenes de productos (opcional)');
            $this->newLine();
            
            $this->warn('⚠️  ESTA ACCIÓN NO SE PUEDE DESHACER ⚠️');
            $this->newLine();

            $confirmacion1 = $this->ask('Escribe "ELIMINAR DATOS" para continuar (o presiona Enter para cancelar)');
            
            if ($confirmacion1 !== 'ELIMINAR DATOS') {
                $this->info('❌ Operación cancelada por el usuario.');
                return 0;
            }

            $confirmacion2 = $this->confirm('¿Estás ABSOLUTAMENTE seguro? Esta es tu última oportunidad para cancelar');
            
            if (!$confirmacion2) {
                $this->info('❌ Operación cancelada por el usuario.');
                return 0;
            }
        }

        $this->info('🚀 Iniciando eliminación de datos...');
        $this->newLine();

        try {
            // Deshabilitar verificación de foreign keys temporalmente
            DB::statement('SET FOREIGN_KEY_CHECKS=0');

            // 1. Eliminar detalles de venta (deben ir primero por foreign keys)
            $this->info('🗑️  Eliminando detalles de venta...');
            $deletedDetails = SaleDetail::count();
            DB::table('sale_details')->truncate();
            $this->info("✅ {$deletedDetails} detalles de venta eliminados");

            // 2. Eliminar ventas
            $this->info('🗑️  Eliminando ventas...');
            $deletedSales = Sale::count();
            DB::table('sales')->truncate();
            $this->info("✅ {$deletedSales} ventas eliminadas");

            // 3. Eliminar imágenes de productos (si no se especifica --keep-images)
            $imagenesEliminadas = 0;
            if (!$this->option('keep-images')) {
                $this->info('🖼️  Eliminando imágenes de productos...');
                $productosConImagen = Product::whereNotNull('image')->get();
                
                foreach ($productosConImagen as $producto) {
                    if ($producto->image && Storage::disk('public')->exists($producto->image)) {
                        Storage::disk('public')->delete($producto->image);
                        $imagenesEliminadas++;
                    }
                }
                $this->info("✅ {$imagenesEliminadas} imágenes eliminadas");
            } else {
                $this->info('📷 Manteniendo imágenes de productos (--keep-images especificado)');
            }

            // 4. Eliminar productos
            $this->info('🗑️  Eliminando productos...');
            $deletedProducts = Product::count();
            DB::table('products')->truncate();
            $this->info("✅ {$deletedProducts} productos eliminados");

            // 5. Resetear IDs auto-incrementales
            $this->info('🔄 Reseteando contadores de ID...');
            DB::statement('ALTER TABLE sales AUTO_INCREMENT = 1');
            DB::statement('ALTER TABLE sale_details AUTO_INCREMENT = 1');
            DB::statement('ALTER TABLE products AUTO_INCREMENT = 1');
            $this->info('✅ Contadores de ID reseteados');

            // Rehabilitar verificación de foreign keys
            DB::statement('SET FOREIGN_KEY_CHECKS=1');

            $this->newLine();
            $this->info('🎉 ELIMINACIÓN COMPLETADA EXITOSAMENTE');
            $this->info('📊 RESUMEN:');
            $this->info("• Ventas eliminadas: {$deletedSales}");
            $this->info("• Detalles eliminados: {$deletedDetails}");
            $this->info("• Productos eliminados: {$deletedProducts}");
            if (!$this->option('keep-images')) {
                $this->info("• Imágenes eliminadas: {$imagenesEliminadas}");
            }
            $this->newLine();
            
            $this->info('💡 Próximos pasos sugeridos:');
            $this->info('1. php artisan migrate:fresh --seed (si quieres datos de prueba)');
            $this->info('2. Crear nuevos productos desde el panel admin');
            $this->info('3. Verificar que las categorías y calidades estén intactas');

        } catch (\Exception $e) {
            // Rehabilitar foreign keys en caso de error
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
            $this->error('❌ ERROR durante la eliminación: ' . $e->getMessage());
            $this->error('⚠️  Algunas tablas podrían haberse vaciado parcialmente');
            $this->warn('💡 Ejecuta: php artisan migrate:fresh --seed para restaurar datos de prueba');
            return 1;
        }

        return 0;
    }
}
