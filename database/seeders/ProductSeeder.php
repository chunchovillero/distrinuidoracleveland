<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Electrónicos
            [
                'name' => 'Smartphone Samsung Galaxy A54',
                'description' => 'Smartphone con pantalla de 6.4", 128GB de almacenamiento, cámara de 50MP',
                'sku' => 'SAMS-A54-128',
                'price' => 1299900,
                'cost' => 1000000,
                'stock' => 25,
                'min_stock' => 5,
                'commission' => 3.85, // 3.85% de comisión
                'category_id' => 1,
                'active' => true,
                'show_in_catalog' => true
            ],
            [
                'name' => 'Laptop HP Pavilion 15',
                'description' => 'Laptop con procesador Intel i5, 8GB RAM, 256GB SSD, Windows 11',
                'sku' => 'HP-PAV15-I5',
                'price' => 2599900,
                'cost' => 2200000,
                'stock' => 15,
                'min_stock' => 3,
                'commission' => 4.62, // 4.62% de comisión
                'category_id' => 1,
                'active' => true,
                'show_in_catalog' => true
            ],
            [
                'name' => 'Auriculares Bluetooth Sony WH-1000XM4',
                'description' => 'Auriculares inalámbricos con cancelación de ruido',
                'sku' => 'SONY-WH1000XM4',
                'price' => 899900,
                'cost' => 650000,
                'stock' => 20,
                'min_stock' => 5,
                'commission' => 3.89, // 3.89% de comisión
                'category_id' => 1,
                'active' => true,
                'show_in_catalog' => true
            ],

            // Ropa y Accesorios
            [
                'name' => 'Camiseta Polo Ralph Lauren',
                'description' => 'Camiseta polo 100% algodón, disponible en varios colores',
                'sku' => 'RL-POLO-001',
                'price' => 159900,
                'cost' => 80000,
                'stock' => 50,
                'min_stock' => 10,
                'commission' => 9.38, // 9.38% de comisión
                'category_id' => 2,
                'active' => true,
                'show_in_catalog' => true
            ],
            [
                'name' => 'Jeans Levis 501 Original',
                'description' => 'Jeans clásicos de corte recto, tela denim premium',
                'sku' => 'LEVIS-501-ORG',
                'price' => 299900,
                'cost' => 180000,
                'stock' => 30,
                'min_stock' => 8,
                'commission' => 8.34, // 8.34% de comisión
                'category_id' => 2,
                'active' => true,
                'show_in_catalog' => true
            ],
            [
                'name' => 'Reloj Casio G-Shock',
                'description' => 'Reloj deportivo resistente al agua, con cronómetro',
                'sku' => 'CASIO-GSHOCK-01',
                'price' => 449900,
                'cost' => 300000,
                'stock' => 18,
                'min_stock' => 4,
                'commission' => 6.67, // 6.67% de comisión
                'category_id' => 2,
                'active' => true,
                'show_in_catalog' => true
            ],

            // Hogar y Jardín
            [
                'name' => 'Cafetera Oster de 12 tazas',
                'description' => 'Cafetera programable con filtro permanente y placa calentadora',
                'sku' => 'OSTER-CAF12',
                'price' => 189900,
                'cost' => 120000,
                'stock' => 22,
                'min_stock' => 6,
                'commission' => 9.48, // 9.48% de comisión
                'category_id' => 3,
                'active' => true,
                'show_in_catalog' => true
            ],
            [
                'name' => 'Aspiradora Electrolux 1600W',
                'description' => 'Aspiradora de trineo con bolsa, potencia 1600W',
                'sku' => 'ELECTROLUX-ASP1600',
                'price' => 349900,
                'cost' => 250000,
                'stock' => 12,
                'min_stock' => 3,
                'commission' => 8.00, // 8.00% de comisión
                'category_id' => 3,
                'active' => true,
                'show_in_catalog' => true
            ],

            // Deportes
            [
                'name' => 'Tenis Nike Air Max 270',
                'description' => 'Tenis deportivos con tecnología Air Max, cómodos para correr',
                'sku' => 'NIKE-AIRMAX270',
                'price' => 459900,
                'cost' => 320000,
                'stock' => 35,
                'min_stock' => 8,
                'commission' => 6.96, // 6.96% de comisión
                'category_id' => 4,
                'active' => true,
                'show_in_catalog' => true
            ],
            [
                'name' => 'Balón Fútbol Adidas Copa Mundial',
                'description' => 'Balón oficial de fútbol, certificado FIFA',
                'sku' => 'ADIDAS-COPA-MUNDIAL',
                'price' => 89900,
                'cost' => 55000,
                'stock' => 40,
                'min_stock' => 10,
                'commission' => 8.90, // 8.90% de comisión
                'category_id' => 4,
                'active' => true,
                'show_in_catalog' => true
            ],

            // Belleza y Cuidado Personal
            [
                'name' => 'Perfume Hugo Boss Bottled',
                'description' => 'Fragancia masculina de 100ml, notas amaderadas',
                'sku' => 'HUGO-BOTTLED-100ML',
                'price' => 269900,
                'cost' => 180000,
                'stock' => 28,
                'min_stock' => 6,
                'commission' => 8.15, // 8.15% de comisión
                'category_id' => 5,
                'active' => true,
                'show_in_catalog' => true
            ],
            [
                'name' => 'Crema Facial Neutrogena Hydra Boost',
                'description' => 'Crema hidratante con ácido hialurónico, 50ml',
                'sku' => 'NEUTROGENA-HYDRA50',
                'price' => 45900,
                'cost' => 28000,
                'stock' => 60,
                'min_stock' => 15,
                'commission' => 9.80, // 9.80% de comisión
                'category_id' => 5,
                'active' => true,
                'show_in_catalog' => true
            ],

            // Libros y Papelería
            [
                'name' => 'Cuaderno Norma Kiut 100 Hojas',
                'description' => 'Cuaderno universitario de 100 hojas, rayado',
                'sku' => 'NORMA-KIUT-100H',
                'price' => 8900,
                'cost' => 5000,
                'stock' => 200,
                'min_stock' => 50,
                'commission' => 8.99, // 8.99% de comisión
                'category_id' => 6,
                'active' => true,
                'show_in_catalog' => true
            ],
            [
                'name' => 'Libro "Cien años de soledad" García Márquez',
                'description' => 'Novela clásica de la literatura latinoamericana',
                'sku' => 'LIBRO-CIEN-AÑOS',
                'price' => 39900,
                'cost' => 25000,
                'stock' => 45,
                'min_stock' => 10,
                'commission' => 8.77, // 8.77% de comisión
                'category_id' => 6,
                'active' => true,
                'show_in_catalog' => true
            ]
        ];

        foreach ($products as $product) {
            \App\Models\Product::create($product);
        }
    }
}
