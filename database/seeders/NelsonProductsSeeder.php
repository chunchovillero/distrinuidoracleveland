<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Calidad;
use App\Models\Proveedor;

class NelsonProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener el proveedor NELSON
        $proveedorNelson = Proveedor::where('nombre', 'NELSON')->first();
        
        if (!$proveedorNelson) {
            echo "❌ Error: Proveedor NELSON no encontrado\n";
            return;
        }

        // Obtener categorías necesarias
        $ropaYAccesoriosId = Category::where('name', 'Ropa y Accesorios')->first()->id;
        $hogarYJardinId = Category::where('name', 'Hogar y Jardín')->first()->id;

        // Obtener calidades - mapeo de nombres variantes
        $calidades = [
            '1° PREMIUN' => Calidad::where('nombre', '1° PREMIUM')->first()->id,
            'PREMIUN' => Calidad::where('nombre', 'PREMIUM')->first()->id,
            '1ERA-2DA' => Calidad::where('nombre', '1ERA-2DA')->first()->id,
            '1 ERA' => Calidad::where('nombre', '1 ERA')->first()->id,
            '' => Calidad::where('nombre', 'PREMIUM')->first()->id, // Para MAMELUCO sin calidad especificada
        ];

        // Lista de productos NELSON con especificaciones
        $productosNelson = [
            ['ABRIGO MIX', '1ERA-2DA', 45, $ropaYAccesoriosId],
            ['BLAIZER JUV FASH', '1° PREMIUN', 45, $ropaYAccesoriosId],
            ['BLUSA INVIERNO', '1 ERA', 45, $ropaYAccesoriosId],
            ['BLUSA VERANO M/C', '1° PREMIUN', 45, $ropaYAccesoriosId],
            ['BOXER', '1° PREMIUN', 45, $ropaYAccesoriosId],
            ['BUZO', '1ERA-2DA', 45, $ropaYAccesoriosId],
            ['BUZO Y CHAQUETA PLUSH', '1 ERA', 45, $ropaYAccesoriosId],
            ['CAMISA HOMBRE M/ LARGA', '1° PREMIUN', 45, $ropaYAccesoriosId],
            ['CUBRECOLCHON', '1ERA-2DA', 37, $hogarYJardinId],
            ['FRAZADA', '1° PREMIUN', 45, $hogarYJardinId],
            ['MAMELUCO', '', 45, $ropaYAccesoriosId],
            ['MIXTO INVIERNO HOMBRE', '1ERA-2DA', 45, $ropaYAccesoriosId],
            ['PANTALON BUZO', '1ERA-2DA', 45, $ropaYAccesoriosId],
            ['PIJAMA NIÑO', '1° PREMIUN', 45, $ropaYAccesoriosId],
            ['PIJAMA POLAR', '1° PREMIUN', 45, $ropaYAccesoriosId],
            ['PLAYERA DAMA M/CORTA', '1ERA-2DA', 45, $ropaYAccesoriosId],
            ['PLAYERA JUV. FASH M/LARGA 1ERA', '1 ERA', 45, $ropaYAccesoriosId],
            ['PLAYERA JUV. FASH M/LARGA PREMIUM', '1° PREMIUN', 45, $ropaYAccesoriosId],
            ['PLAYERA MIXTA MUJER M/L', '1° PREMIUN', 45, $ropaYAccesoriosId],
            ['POLAR FASHION', '1 ERA', 45, $ropaYAccesoriosId],
            ['POLERA HOMBRE M/L', '1° PREMIUN', 45, $ropaYAccesoriosId],
            ['POLERON CON GORRO HOMBRE', '1° PREMIUN', 45, $ropaYAccesoriosId],
            ['PONCHO Y TAPADO', '1° PREMIUN', 45, $ropaYAccesoriosId],
            ['ROPA CLINICA', '1° PREMIUN', 45, $ropaYAccesoriosId],
            ['ROPA HOSPITAL', '1 ERA', 45, $ropaYAccesoriosId],
            ['ROPA NIÑO', 'PREMIUN', 45, $ropaYAccesoriosId],
            ['SABANA', '1° PREMIUN', 45, $hogarYJardinId],
            ['SABANA FRANELA (FLAMMEL)', '1ERA-2DA', 45, $hogarYJardinId],
            ['SURTIDO JUVENIL FASHION', '1° PREMIUN', 45, $ropaYAccesoriosId],
            ['SURTIDO JUVENIL T/ GRANDE', '1° PREMIUN', 45, $ropaYAccesoriosId],
            ['SWEATER HOMBRE', '1 ERA', 45, $ropaYAccesoriosId],
            ['SWEATER JUVENIL', '1° PREMIUN', 45, $ropaYAccesoriosId],
            ['SWEATER LANA', '1 ERA', 45, $ropaYAccesoriosId],
            ['SWEATER MIX 1ERA', '1 ERA', 45, $ropaYAccesoriosId],
            ['SWEATER MIX PREMIUM', '1° PREMIUN', 45, $ropaYAccesoriosId],
        ];

        echo "🚀 Creando productos NELSON...\n";
        $contador = 0;

        foreach ($productosNelson as $index => $item) {
            [$nombre, $calidadNombre, $kilos, $categoriaId] = $item;
            
            // Generar SKU único basado en el nombre
            $sku = 'NEL-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT) . '-' . 
                   strtoupper(substr(str_replace([' ', '/', '°', '.', '(', ')'], ['', '', 'O', '', '', ''], $nombre), 0, 4));
            
            // Precio aleatorio entre $35,000 y $300,000
            $precio = rand(35000, 300000);
            
            // Comisión aleatoria entre 5% y 20%
            $comision = rand(500, 2000) / 100; // 5.00 a 20.00
            
            // Stock aleatorio entre 10 y 100
            $stock = rand(10, 100);
            
            // Obtener ID de calidad
            $calidadId = $calidades[$calidadNombre] ?? $calidades['1° PREMIUN'];
            
            // Crear el producto
            $producto = Product::create([
                'name' => $nombre,
                'description' => "Producto de alta calidad de la línea NELSON. Calidad: " . ($calidadNombre ?: 'PREMIUM') . ". Peso: {$kilos}kg.",
                'sku' => $sku,
                'price' => $precio,
                'cost' => round($precio * 0.6), // Costo estimado 60% del precio
                'stock' => $stock,
                'min_stock' => 0, // Stock mínimo en 0
                'kilos' => $kilos,
                'commission' => $comision,
                'category_id' => $categoriaId,
                'calidad_id' => $calidadId,
                'proveedor_id' => $proveedorNelson->id,
                'active' => true,
                'show_in_catalog' => true
            ]);
            
            $contador++;
        }

        echo "✅ {$contador} productos NELSON creados exitosamente!\n";
        echo "💰 Precios: \$35,000 - \$300,000\n";
        echo "📦 Stock: 10 - 100 unidades\n";
        echo "💼 Comisiones: 5% - 20%\n";
        echo "⚖️  Pesos: según especificación (37kg - 45kg)\n";
        echo "📋 Stock mínimo: 0\n";
    }
}
