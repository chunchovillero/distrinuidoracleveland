<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Calidad;
use App\Models\Proveedor;

class UfoProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener el proveedor UFO
        $proveedorUfo = Proveedor::where('nombre', 'UFO')->first();
        
        if (!$proveedorUfo) {
            echo "❌ Error: Proveedor UFO no encontrado\n";
            return;
        }

        // Obtener categorías necesarias
        $ropaYAccesoriosId = Category::where('name', 'Ropa y Accesorios')->first()->id;
        $hogarYJardinId = Category::where('name', 'Hogar y Jardín')->first()->id;

        // Obtener calidades
        $calidades = [
            '1° PREMIUN' => Calidad::where('nombre', '1° PREMIUM')->first()->id,
            '1ERA-2DA' => Calidad::where('nombre', '1ERA-2DA')->first()->id,
            'PREMIUN' => Calidad::where('nombre', 'PREMIUM')->first()->id,
            '1 ERA' => Calidad::where('nombre', '1 ERA')->first()->id,
        ];

        // Lista de productos UFO con especificaciones
        $productosUfo = [
            ['ABRIGO DAMA 3/4', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['BLAIZER JUVENIL', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['BLUSA BLUSON M/ CORTA', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['BLUSA BLUSON TOP', '1° PREMIUN', 20, $ropaYAccesoriosId],
            ['BLUSA MANGA LARGA', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['BLUSA VERANO M/ CORTA', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['CHAQUETA CUERO', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['CHAQUETA GAMUZA', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['FALDA INVIERNO', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['FALDA JEANS', '1ERA-2DA', 37, $ropaYAccesoriosId],
            ['FALDA JEANS PREMIUM', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['FRAZADA', '1° PREMIUN', 37, $hogarYJardinId],
            ['GORRO Y BUFANDA', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['PANTALON BUZO', '1ERA-2DA', 37, $ropaYAccesoriosId],
            ['PANTALON COTELE', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['PANTALON DAMA LEGGINS', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['PANTALON DAMA VERANO', '1° PREMIUN', 20, $ropaYAccesoriosId],
            ['PANTALON KAKY', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['PANTY LANA', '1° PREMIUN', 20, $ropaYAccesoriosId],
            ['PIJAMA VERANO', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['POLERA DAMA M/ CORTA', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['POLERA HOMBRE M/ CORTA', '1° PREMIUN', 25, $ropaYAccesoriosId],
            ['POLERON MIX STANDARD', 'PREMIUN', 37, $ropaYAccesoriosId],
            ['POLERON MIX PREMIUM', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['RENO GAMUZA', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['ROPA HINDU', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['ROPA NIÑO INVIERNO', '1ERA-2DA', 37, $ropaYAccesoriosId],
            ['ROPA NIÑO VERANO', '1ERA-2DA', 37, $ropaYAccesoriosId],
            ['SABANA PREMIUM', '1° PREMIUN', 37, $hogarYJardinId],
            ['SABANA STANDARD', '1 ERA', 37, $hogarYJardinId],
            ['SURTIDO ACETATO', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['SURTIDO DAMA T/ GRANDE', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['SURTIDO PLUSH', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['SURTIDO RENO', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['SURTIDO SINTETICO', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['SURTIDO VERANO T/ GR.', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['TRAJE BAÑO', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['TRAJE DOS PIEZA INVIERNO', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['TRAJE DOS PIEZA VERANO', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['VESTIDO FIESTA', '1° PREMIUN', 20, $ropaYAccesoriosId],
            ['VESTIDO INVIERNO STANDARD', '1ERA-2DA', 37, $ropaYAccesoriosId],
            ['VESTIDO INVIERNO PREMIUM', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['VESTIDO OTOÑO INVIERNO', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['VESTIDO VERANO', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['VESTIDO VISCOSA', '1° PREMIUN', 20, $ropaYAccesoriosId],
        ];

        echo "🚀 Creando productos UFO...\n";
        $contador = 0;

        foreach ($productosUfo as $index => $item) {
            [$nombre, $calidadNombre, $kilos, $categoriaId] = $item;
            
            // Generar SKU único basado en el nombre
            $sku = 'UFO-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT) . '-' . 
                   strtoupper(substr(str_replace([' ', '/', '°'], ['', '', 'O'], $nombre), 0, 4));
            
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
                'description' => "Producto de alta calidad de la línea UFO. Calidad: {$calidadNombre}. Peso: {$kilos}kg.",
                'sku' => $sku,
                'price' => $precio,
                'cost' => round($precio * 0.6), // Costo estimado 60% del precio
                'stock' => $stock,
                'min_stock' => 0, // Stock mínimo en 0
                'kilos' => $kilos,
                'commission' => $comision,
                'category_id' => $categoriaId,
                'calidad_id' => $calidadId,
                'proveedor_id' => $proveedorUfo->id,
                'active' => true,
                'show_in_catalog' => true
            ]);
            
            $contador++;
        }

        echo "✅ {$contador} productos UFO creados exitosamente!\n";
        echo "💰 Precios: \$35,000 - \$300,000\n";
        echo "📦 Stock: 10 - 100 unidades\n";
        echo "💼 Comisiones: 5% - 20%\n";
        echo "⚖️  Pesos: según especificación (20kg - 37kg)\n";
    }
}
