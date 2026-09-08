<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Calidad;
use App\Models\Proveedor;

class SelinVestuarioProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener el proveedor SELIN VESTUARIO
        $proveedorSelinVestuario = Proveedor::where('nombre', 'SELIN VESTUARIO')->first();
        
        if (!$proveedorSelinVestuario) {
            echo "❌ Error: Proveedor SELIN VESTUARIO no encontrado\n";
            return;
        }

        // Obtener categorías necesarias
        $ropaYAccesoriosId = Category::where('name', 'Ropa y Accesorios')->first()->id;

        // Obtener calidades - mapeo de nombres variantes
        $calidades = [
            '1° PREMIUN' => Calidad::where('nombre', '1° PREMIUM')->first()->id,
            'PREMIUN' => Calidad::where('nombre', 'PREMIUM')->first()->id,
            '1ERA-2DA' => Calidad::where('nombre', '1ERA-2DA')->first()->id,
            '1 ERA' => Calidad::where('nombre', '1 ERA')->first()->id,
        ];

        // Lista de productos SELIN VESTUARIO con especificaciones
        $productosSelinVestuario = [
            ['ABRIGO DAMA FASHION 3/4 INV 1ERA', '1 ERA', 37, $ropaYAccesoriosId],
            ['ABRIGO DAMA FASHION 3/4 INV PREMIUM', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['ABRIGO DAMA LARGO', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['ABRIGO HOMBRE', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['ABRIGO MIXTO', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['BEATLE', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['BLAIZER DAMA FASH VERANO', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['BLAIZER DAMA FASHION INV. PREMIUM', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['BLAIZER DAMA FASHION INV. 1ERA', '1 ERA', 37, $ropaYAccesoriosId],
            ['BLAIZER DAMA FASHION VERANO', '1 ERA', 37, $ropaYAccesoriosId],
            ['BLUSA BLUSON M/ LARGA 1ERA-2DA', '1ERA-2DA', 37, $ropaYAccesoriosId],
            ['BLUSA BLUSON M/ LARGA PREMIUM', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['BLUSA BLUSON M/CORTA 1ERA-2DA', '1ERA-2DA', 37, $ropaYAccesoriosId],
            ['BLUSA BLUSON M/CORTA PREMIUM', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['BODY', '1° PREMIUN', 20, $ropaYAccesoriosId],
            ['CALCETIN 20K 1ERA-2DA', '1ERA-2DA', 20, $ropaYAccesoriosId],
            ['CALCETIN 20K PREMIUM', '1° PREMIUN', 20, $ropaYAccesoriosId],
            ['CALCETIN 37K 1ERA-2DA', '1ERA-2DA', 37, $ropaYAccesoriosId],
            ['CALCETIN 37K PREMIUM', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['CALZA LEGGINS 20K', '1° PREMIUN', 20, $ropaYAccesoriosId],
            ['CALZA LEGGINS 37K', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['CAMISA FRANELA 20K', '1° PREMIUN', 20, $ropaYAccesoriosId],
            ['CAMISA FRANELA 37K', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['CAMISA INVIERNO PREMIUM', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['CAMISA INVIERNO 1ERA', '1 ERA', 37, $ropaYAccesoriosId],
            ['CAMISA JEANS 20K PREMIUM', '1° PREMIUN', 20, $ropaYAccesoriosId],
            ['CAMISA JEANS 20K STANDARD', 'PREMIUN', 20, $ropaYAccesoriosId],
            ['CARTERA 20K', '1° PREMIUN', 20, $ropaYAccesoriosId],
            ['CARTERA 37K', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['CHAQUETA COTELE', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['CHAQUETA JEANS 1ERA-2DA', '1ERA-2DA', 37, $ropaYAccesoriosId],
            ['CHAQUETA JEANS PREMIUM', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['CHAQUETA PIEL', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['DISFRAZ', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['FALDA INVIERNO PREMIUM', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['FALDA INVIERNO 1ERA-2DA', '1ERA-2DA', 37, $ropaYAccesoriosId],
            ['IMPERMEABLE DAMA', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['IMPERMEABLE HOMBRE', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['JEANS DAMA FASHION', 'PREMIUN', 37, $ropaYAccesoriosId],
            ['JEANS DAMA FASHION ANCHO', 'PREMIUN', 37, $ropaYAccesoriosId],
            ['JEANS MAX HOMBRE', 'PREMIUN', 37, $ropaYAccesoriosId],
            ['JEANS MIX', '1 ERA', 37, $ropaYAccesoriosId],
            ['MEXICANO (PONCHO ARTESANAL)', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['PANTALON BUZO 1ERA', '1 ERA', 37, $ropaYAccesoriosId],
            ['PANTALON BUZO 20K PREMIUM', '1° PREMIUN', 20, $ropaYAccesoriosId],
            ['PANTALON BUZO 37K PREMIUM', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['PANTALON COTELE DAMA', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['PANTALON COTELE HOMBRE', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['PANTALON DAMA LANA', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['PANTALON VESTIR DAMA', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['PANTY FINA 20K', '1° PREMIUN', 20, $ropaYAccesoriosId],
            ['PANTY FINA 37K', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['PARKA DELGADA 1ERA-2DA', '1ERA-2DA', 37, $ropaYAccesoriosId],
            ['PARKA DELGADA PREMIUM', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['PARKA LIVIANA', '1ERA-2DA', 37, $ropaYAccesoriosId],
            ['PARKA NINO', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['PARKA SIN MANGA 20K PREMIUM', '1° PREMIUN', 20, $ropaYAccesoriosId],
            ['PARKA SIN MANGA 20K 1ERA-2DA', '1ERA-2DA', 20, $ropaYAccesoriosId],
            ['PESCADOR CAPRI', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['PETO DEPORTIVO 20K 1ERA-2DA', '1ERA-2DA', 20, $ropaYAccesoriosId],
            ['PETO DEPORTIVO 20K PREMIUM', '1° PREMIUN', 20, $ropaYAccesoriosId],
            ['PIJAMA INVIERNO PREMIUM', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['PIJAMA INVIERNO 1ERA-2DA', '1ERA-2DA', 37, $ropaYAccesoriosId],
            ['POLAR MIX PREMIUM', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['POLAR MIX 1ERA-2DA', '1ERA-2DA', 37, $ropaYAccesoriosId],
            ['POLERA DAMA M/ LARGA 1ERA-2DA', '1ERA-2DA', 37, $ropaYAccesoriosId],
            ['POLERA DAMA M/ LARGA PREMIUM', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['POLERA DAMA M/CORTA PREMIUM', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['POLERA DAMA M/CORTA 1ERA-2DA', '1ERA-2DA', 37, $ropaYAccesoriosId],
            ['POLERA HOMBRE M/CORTA PREMIUM', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['POLERA HOMBRE M/CORTA 1ERA-2DA', '1ERA-2DA', 37, $ropaYAccesoriosId],
            ['POLERON CON GORRO 37K PREMIUM', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['POLERON CON GORRO 37K 1ERA-2DA', '1ERA-2DA', 37, $ropaYAccesoriosId],
            ['POLERON CON GORRO 20K 1ERA-2DA', '1ERA-2DA', 20, $ropaYAccesoriosId],
            ['POLERON CON GORRO 20K PREMIUM', '1° PREMIUN', 20, $ropaYAccesoriosId],
            ['POLERON MIX 1ERA-2DA', '1ERA-2DA', 37, $ropaYAccesoriosId],
            ['POLERON MIX PREMIUM', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['PONCHO Y TAPADOS', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['RENO GAMULAN PREMIUM', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['RENO GAMULAN 1ERA-2DA', '1ERA-2DA', 37, $ropaYAccesoriosId],
            ['ROPA DE AGUA LLUVIA', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['ROPA INTERIOR 20K 1ERA-2DA', '1ERA-2DA', 20, $ropaYAccesoriosId],
            ['ROPA INTERIOR 20K PREMIUM', '1° PREMIUN', 20, $ropaYAccesoriosId],
            ['ROPA INTERIOR 37K 1ERA-2DA', '1ERA-2DA', 37, $ropaYAccesoriosId],
            ['ROPA INTERIOR 37K PREMIUM', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['ROPA MILITAR 20K PREMIUM', '1° PREMIUN', 20, $ropaYAccesoriosId],
            ['ROPA MILITAR 20K 1ERA', '1 ERA', 20, $ropaYAccesoriosId],
            ['ROPA NIÑO INVIERNO 37K PREMIUM A', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['ROPA NIÑO INVIERNO 37K 1ERA-2DA', '1ERA-2DA', 37, $ropaYAccesoriosId],
            ['ROPA NIÑO INVIERNO 37K PREMIUM B', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['ROPA NIÑO VERANO', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['ROPA TERMICA SKY 20K PREMIUM', '1° PREMIUN', 20, $ropaYAccesoriosId],
            ['ROPA TERMICA SKY 20K 1ERA-2DA', '1ERA-2DA', 20, $ropaYAccesoriosId],
            ['SHORT TRUNK 1ERA-2DA', '1ERA-2DA', 20, $ropaYAccesoriosId],
            ['SHORT TRUNK PREMIUM', '1° PREMIUN', 20, $ropaYAccesoriosId],
            ['SOSTEN PREMIUM', '1° PREMIUN', 20, $ropaYAccesoriosId],
            ['SOSTEN 1ERA-2DA', '1ERA-2DA', 20, $ropaYAccesoriosId],
            ['SURTIDO PUSH', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['SURTIDO RENO PREMIUM', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['SURTIDO RENO 1ERA-2DA', '1ERA-2DA', 37, $ropaYAccesoriosId],
            ['SURTIDO SINTETICO', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['SWEATER MIX PREMIUM', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['SWEATER ABIERTO Y CARD. PREMIUM', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['SWEATER ABIERTO Y CARD. 1ERA-2DA', '1ERA-2DA', 37, $ropaYAccesoriosId],
            ['SWEATER MIX 1ERA-2DA', '1ERA-2DA', 37, $ropaYAccesoriosId],
            ['TRAJE BAÑO', '1 ERA', 37, $ropaYAccesoriosId],
            ['VESTIDO FIESTA', '1° PREMIUN', 20, $ropaYAccesoriosId],
            ['VESTIDO INVIERNO PREMIUM', '1° PREMIUN', 37, $ropaYAccesoriosId],
            ['VESTIDO INVIERNO 1ERA-2DA', '1ERA-2DA', 37, $ropaYAccesoriosId],
            ['VESTIDO NOVIA', '1° PREMIUN', 20, $ropaYAccesoriosId],
            ['VESTIDO VERANO 1ERA-2DA', '1ERA-2DA', 37, $ropaYAccesoriosId],
            ['VESTIDO VERANO PREMIUM', '1° PREMIUN', 37, $ropaYAccesoriosId],
        ];

        echo "🚀 Creando productos SELIN VESTUARIO...\n";
        $contador = 0;

        foreach ($productosSelinVestuario as $index => $item) {
            [$nombre, $calidadNombre, $kilos, $categoriaId] = $item;
            
            // Generar SKU único basado en el nombre
            $sku = 'SV-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT) . '-' . 
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
                'description' => "Producto de alta calidad de la línea SELIN VESTUARIO. Calidad: {$calidadNombre}. Peso: {$kilos}kg.",
                'sku' => $sku,
                'price' => $precio,
                'cost' => round($precio * 0.6), // Costo estimado 60% del precio
                'stock' => $stock,
                'min_stock' => 0, // Stock mínimo en 0
                'kilos' => $kilos,
                'commission' => $comision,
                'category_id' => $categoriaId,
                'calidad_id' => $calidadId,
                'proveedor_id' => $proveedorSelinVestuario->id,
                'active' => true,
                'show_in_catalog' => true
            ]);
            
            $contador++;
        }

        echo "✅ {$contador} productos SELIN VESTUARIO creados exitosamente!\n";
        echo "💰 Precios: \$35,000 - \$300,000\n";
        echo "📦 Stock: 10 - 100 unidades\n";
        echo "💼 Comisiones: 5% - 20%\n";
        echo "⚖️  Pesos: según especificación (20kg - 37kg)\n";
        echo "📋 Stock mínimo: 0\n";
        echo "👔 Especialización: Vestuario completo y moda\n";
    }
}
