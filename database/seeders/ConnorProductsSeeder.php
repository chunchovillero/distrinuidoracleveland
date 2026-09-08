<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Calidad;
use App\Models\Proveedor;

class ConnorProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener el proveedor CONNOR
        $proveedorConnor = Proveedor::where('nombre', 'CONNOR')->first();
        
        if (!$proveedorConnor) {
            echo "❌ Error: Proveedor CONNOR no encontrado\n";
            return;
        }

        // Obtener categorías necesarias
        $ropaYAccesoriosId = Category::where('name', 'Ropa y Accesorios')->first()->id;
        $hogarYJardinId = Category::where('name', 'Hogar y Jardín')->first()->id;

        // Obtener calidades - mapeo de nombres variantes
        $calidades = [
            '1° PREMIUN' => Calidad::where('nombre', '1° PREMIUM')->first()->id,
            'PREMIUN' => Calidad::where('nombre', 'PREMIUM')->first()->id,
            '2 DA' => Calidad::where('nombre', '1ERA-2DA')->first()->id,
            '1 ERA' => Calidad::where('nombre', '1 ERA')->first()->id,
            '1ERA PLUS' => Calidad::where('nombre', '1° PREMIUM')->first()->id, // Mapeamos a 1° PREMIUM
            'Oferta' => Calidad::where('nombre', 'PREMIUM')->first()->id, // Mapeamos a PREMIUM
        ];

        // Lista de productos CONNOR con especificaciones
        $productosConnor = [
            ['BLUSA INVIERNO', '1° PREMIUN', 45, $ropaYAccesoriosId],
            ['CAMISA FRANELA', 'PREMIUN', 25, $ropaYAccesoriosId],
            ['CHAQUETA COTELE', '1° PREMIUN', 45, $ropaYAccesoriosId],
            ['COBERTOR', '1° PREMIUN', 45, $hogarYJardinId],
            ['FAJAS', '2 DA', 20, $ropaYAccesoriosId],
            ['FUNDAS', '1 ERA', 45, $hogarYJardinId],
            ['JEAN PITILLO', 'Oferta', 25, $ropaYAccesoriosId],
            ['MIXTO JUVENIL INVIERNO', '1 ERA', 45, $ropaYAccesoriosId],
            ['MIXTO JUVENIL INVIERNO PREMIUM', 'PREMIUN', 25, $ropaYAccesoriosId],
            ['MIXTO MUJER', '1ERA PLUS', 25, $ropaYAccesoriosId],
            ['PARKA MODERNA', '1 ERA', 45, $ropaYAccesoriosId],
            ['PARKA SACO', '1 ERA', 20, $ropaYAccesoriosId],
            ['PITILLO', 'PREMIUN', 25, $ropaYAccesoriosId],
            ['POLAR CON CIERRE', '1 ERA', 45, $ropaYAccesoriosId],
            ['POLERON CON CHIPORRO', '1 ERA', 45, $ropaYAccesoriosId],
            ['POLERON MIX', '1° PREMIUN', 45, $ropaYAccesoriosId],
            ['POLERON NIÑO', '1 ERA', 45, $ropaYAccesoriosId],
            ['ROPA CASA', '1 ERA', 45, $ropaYAccesoriosId],
            ['ROPA NIÑO SACO', 'PREMIUN', 25, $ropaYAccesoriosId],
            ['SURTIDO JUVENIL', '1 ERA', 45, $ropaYAccesoriosId],
            ['SWEATER HOMBRE MOD.', 'PREMIUN', 25, $ropaYAccesoriosId],
            ['SWEATER JUVENIL', '1 ERA', 45, $ropaYAccesoriosId],
            ['SWEATER LANA DAMA', '1° PREMIUN', 40, $ropaYAccesoriosId],
            ['TERMICO NIEVE NIÑO', 'PREMIUN', 25, $ropaYAccesoriosId],
        ];

        echo "🚀 Creando productos CONNOR...\n";
        $contador = 0;

        foreach ($productosConnor as $index => $item) {
            [$nombre, $calidadNombre, $kilos, $categoriaId] = $item;
            
            // Generar SKU único basado en el nombre
            $sku = 'CON-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT) . '-' . 
                   strtoupper(substr(str_replace([' ', '/', '°', '.'], ['', '', 'O', ''], $nombre), 0, 4));
            
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
                'description' => "Producto de alta calidad de la línea CONNOR. Calidad: {$calidadNombre}. Peso: {$kilos}kg.",
                'sku' => $sku,
                'price' => $precio,
                'cost' => round($precio * 0.6), // Costo estimado 60% del precio
                'stock' => $stock,
                'min_stock' => 0, // Stock mínimo en 0
                'kilos' => $kilos,
                'commission' => $comision,
                'category_id' => $categoriaId,
                'calidad_id' => $calidadId,
                'proveedor_id' => $proveedorConnor->id,
                'active' => true,
                'show_in_catalog' => true
            ]);
            
            $contador++;
        }

        echo "✅ {$contador} productos CONNOR creados exitosamente!\n";
        echo "💰 Precios: \$35,000 - \$300,000\n";
        echo "📦 Stock: 10 - 100 unidades\n";
        echo "💼 Comisiones: 5% - 20%\n";
        echo "⚖️  Pesos: según especificación (20kg - 45kg)\n";
        echo "📋 Stock mínimo: 0\n";
    }
}
