<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electrónicos',
                'description' => 'Productos electrónicos y tecnológicos',
                'active' => true
            ],
            [
                'name' => 'Ropa y Accesorios',
                'description' => 'Prendas de vestir y accesorios de moda',
                'active' => true
            ],
            [
                'name' => 'Hogar y Jardín',
                'description' => 'Artículos para el hogar y jardinería',
                'active' => true
            ],
            [
                'name' => 'Deportes',
                'description' => 'Artículos deportivos y fitness',
                'active' => true
            ],
            [
                'name' => 'Belleza y Cuidado Personal',
                'description' => 'Productos de belleza y cuidado personal',
                'active' => true
            ],
            [
                'name' => 'Libros y Papelería',
                'description' => 'Libros, útiles escolares y de oficina',
                'active' => true
            ]
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}
