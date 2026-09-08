<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Calidad;
use App\Models\Proveedor;

class SelinHogarProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener el proveedor SELIN HOGAR
        $proveedorSelinHogar = Proveedor::where('nombre', 'SELIN HOGAR')->first();
        
        if (!$proveedorSelinHogar) {
            echo "❌ Error: Proveedor SELIN HOGAR no encontrado\n";
            return;
        }

        // Obtener categorías necesarias
        $ropaYAccesoriosId = Category::where('name', 'Ropa y Accesorios')->first()->id;
        $hogarYJardinId = Category::where('name', 'Hogar y Jardín')->first()->id;

        // Obtener calidades - mapeo de nombres variantes
        $calidades = [
            '1° PREMIUN' => Calidad::where('nombre', '1° PREMIUM')->first()->id,
            '1ERA-2DA' => Calidad::where('nombre', '1ERA-2DA')->first()->id,
            '1 ERA' => Calidad::where('nombre', '1 ERA')->first()->id,
            'NUEVA' => Calidad::where('nombre', '1° PREMIUM')->first()->id, // Mapeamos NUEVA a 1° PREMIUM
        ];

        // Lista de productos SELIN HOGAR con especificaciones
        $productosSelinHogar = [
            ['BOLSO MOCHILA', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['CARTERA 37K', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['CARTERA 20K', '1° PREMIUN', 20, $ropaYAccesoriosId],
            ['COBERTOR 1ERA-2DA', '1ERA-2DA', 37, $hogarYJardinId],
            ['COBERTOR PREMIUM', '1° PREMIUN', 37, $hogarYJardinId],
            ['COJIN 1ERA-2DA', '1ERA-2DA', 37, $hogarYJardinId],
            ['COJIN PREMIUM', '1° PREMIUN', 37, $hogarYJardinId],
            ['COLCHALANA', '1° PREMIUN', 30, $hogarYJardinId],
            ['CORTINA 20K PREMIUM', '1° PREMIUN', 20, $hogarYJardinId],
            ['CORTINA 20K 1ERA-2DA', '1ERA-2DA', 20, $hogarYJardinId],
            ['CORTINA 37K', '1° PREMIUN', 37, $hogarYJardinId],
            ['CUBRECAMA PREMIUM', '1° PREMIUN', 37, $hogarYJardinId],
            ['CUBRECAMA 1ERA-2DA', '1ERA-2DA', 37, $hogarYJardinId],
            ['CUBRECOBERTOR PREMIUM', '1° PREMIUN', 37, $hogarYJardinId],
            ['CUBRECOBERTOR 1ERA-2DA', '1ERA-2DA', 37, $hogarYJardinId],
            ['CUBRECOLCHON 1ERA-2DA', '1ERA-2DA', 20, $hogarYJardinId],
            ['CUBRECOLCHON PREMIUM', '1° PREMIUN', 20, $hogarYJardinId],
            ['FALDON', '1° PREMIUN', 37, $hogarYJardinId],
            ['FRAZADA 1ERA-2DA', '1ERA-2DA', 37, $hogarYJardinId],
            ['FRAZADA PREMIUM', '1° PREMIUN', 37, $hogarYJardinId],
            ['FRAZADA COLCHA', 'NUEVA', 37, $hogarYJardinId],
            ['FUNDA ALMOHADA 1ERA', '1 ERA', 37, $hogarYJardinId],
            ['FUNDA ALMOHADA PREMIUM', '1° PREMIUN', 37, $hogarYJardinId],
            ['INDIVIDUAL Y PAÑO PREMIUM', '1° PREMIUN', 37, $hogarYJardinId],
            ['INDIVIDUAL Y PAÑO 1ERA-2DA', '1ERA-2DA', 37, $hogarYJardinId],
            ['MANTEL 37K PREMIUM', '1° PREMIUN', 37, $hogarYJardinId],
            ['MANTEL 20K PREMIUM', '1° PREMIUN', 20, $hogarYJardinId],
            ['MANTEL 37K 1ERA-2DA A', '1ERA-2DA', 37, $hogarYJardinId],
            ['MANTEL 37K 1ERA-2DA B', '1ERA-2DA', 37, $hogarYJardinId],
            ['OVILLO LANA', '1° PREMIUN', 20, $ropaYAccesoriosId],
            ['PISO BAÑO 1ERA-2DA', '1ERA-2DA', 37, $hogarYJardinId],
            ['PISO BAÑO PREMIUM', '1° PREMIUN', 37, $hogarYJardinId],
            ['ROPA CASA 1ERA-2DA', '1ERA-2DA', 37, $ropaYAccesoriosId],
            ['ROPA CASA PREMIUM', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['ROPA MASCOTA', '1° PREMIUN', 20, $ropaYAccesoriosId],
            ['SABANA 1ERA', '1 ERA', 37, $hogarYJardinId],
            ['SABANA PREMIUM', '1° PREMIUN', 37, $hogarYJardinId],
            ['TOALLA 20K PREMIUM', '1° PREMIUN', 20, $hogarYJardinId],
            ['TOALLA 20K 1ERA-2DA', '1ERA-2DA', 20, $hogarYJardinId],
            ['VISILLO 20K', '1° PREMIUN', 20, $hogarYJardinId],
            ['VISILLO 37K', '1° PREMIUN', 37, $hogarYJardinId],
        ];

        echo "🚀 Creando productos SELIN HOGAR...\n";
        $contador = 0;

        foreach ($productosSelinHogar as $index => $item) {
            [$nombre, $calidadNombre, $kilos, $categoriaId] = $item;
            
            // Generar SKU único basado en el nombre
            $sku = 'SH-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT) . '-' . 
                   strtoupper(substr(str_replace([' ', '/', '°', '.', '(', ')', '-'], ['', '', 'O', '', '', '', ''], $nombre), 0, 4));
            
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
                'description' => "Producto de alta calidad de la línea SELIN HOGAR. Calidad: {$calidadNombre}. Peso: {$kilos}kg.",
                'sku' => $sku,
                'price' => $precio,
                'cost' => round($precio * 0.6), // Costo estimado 60% del precio
                'stock' => $stock,
                'min_stock' => 0, // Stock mínimo en 0
                'kilos' => $kilos,
                'commission' => $comision,
                'category_id' => $categoriaId,
                'calidad_id' => $calidadId,
                'proveedor_id' => $proveedorSelinHogar->id,
                'active' => true,
                'show_in_catalog' => true
            ]);
            
            $contador++;
        }

        echo "✅ {$contador} productos SELIN HOGAR creados exitosamente!\n";
        echo "💰 Precios: \$35,000 - \$300,000\n";
        echo "📦 Stock: 10 - 100 unidades\n";
        echo "💼 Comisiones: 5% - 20%\n";
        echo "⚖️  Pesos: según especificación (20kg - 37kg)\n";
        echo "📋 Stock mínimo: 0\n";
        echo "🏠 Especialización: Productos para el hogar y accesorios\n";
    }
}
