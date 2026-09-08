<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\SaleDetail;

class VerifyProductDeletionSafety extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:verify-deletion-safety {--show-safe : Mostrar solo productos que se pueden eliminar} {--show-unsafe : Mostrar solo productos que NO se pueden eliminar}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica qué productos se pueden eliminar de forma segura sin afectar el historial de ventas';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Verificando seguridad para eliminación de productos...');
        $this->newLine();

        $productos = Product::all();
        $segurosParaEliminar = [];
        $noSegurosParaEliminar = [];

        foreach ($productos as $producto) {
            $ventasCount = SaleDetail::where('product_id', $producto->id)->count();
            
            if ($ventasCount > 0) {
                $noSegurosParaEliminar[] = [
                    'id' => $producto->id,
                    'nombre' => $producto->name,
                    'sku' => $producto->sku,
                    'activo' => $producto->active ? 'Sí' : 'No',
                    'ventas' => $ventasCount
                ];
            } else {
                $segurosParaEliminar[] = [
                    'id' => $producto->id,
                    'nombre' => $producto->name,
                    'sku' => $producto->sku,
                    'activo' => $producto->active ? 'Sí' : 'No',
                    'stock' => $producto->stock
                ];
            }
        }

        // Mostrar resumen
        $this->info("📊 RESUMEN:");
        $this->info("Total de productos: " . $productos->count());
        $this->info("✅ Seguros para eliminar: " . count($segurosParaEliminar));
        $this->info("❌ NO seguros para eliminar: " . count($noSegurosParaEliminar));
        $this->newLine();

        // Mostrar productos seguros
        if (!$this->option('show-unsafe') && (count($segurosParaEliminar) > 0)) {
            $this->info("✅ PRODUCTOS SEGUROS PARA ELIMINAR (sin ventas asociadas):");
            
            if (count($segurosParaEliminar) > 0) {
                $this->table(
                    ['ID', 'Nombre', 'SKU', 'Activo', 'Stock'],
                    $segurosParaEliminar
                );
                
                if (count($segurosParaEliminar) > 0) {
                    $this->warn("💡 Recomendación: Considera primero desactivar estos productos en lugar de eliminarlos.");
                }
            }
            $this->newLine();
        }

        // Mostrar productos no seguros
        if (!$this->option('show-safe') && (count($noSegurosParaEliminar) > 0)) {
            $this->info("❌ PRODUCTOS NO SEGUROS PARA ELIMINAR (con ventas asociadas):");
            
            if (count($noSegurosParaEliminar) > 0) {
                $this->table(
                    ['ID', 'Nombre', 'SKU', 'Activo', 'Ventas'],
                    $noSegurosParaEliminar
                );
                
                $this->error("⚠️  IMPORTANTE: Estos productos NO deben eliminarse para preservar la integridad del historial de ventas.");
                $this->info("💡 Alternativa: Desactiva estos productos si ya no los comercializas.");
            }
            $this->newLine();
        }

        // Recomendaciones finales
        $this->info("📋 RECOMENDACIONES:");
        $this->info("1. 🔒 Nunca elimines productos con ventas asociadas");
        $this->info("2. 🔄 Usa la opción 'Desactivar' para productos descontinuados");
        $this->info("3. 🗑️  Solo elimina productos creados por error y sin historial");
        $this->info("4. 📊 Ejecuta este comando regularmente para mantener control");

        return 0;
    }
}
