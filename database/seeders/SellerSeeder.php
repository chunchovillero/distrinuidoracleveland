<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sellers = [
            [
                'name' => 'Juan Pérez',
                'email' => 'juan.perez@empresa.com',
                'phone' => '3001234567',
                'address' => 'Calle 123 #45-67, Bogotá',
                'active' => true
            ],
            [
                'name' => 'María García',
                'email' => 'maria.garcia@empresa.com',
                'phone' => '3007654321',
                'address' => 'Carrera 50 #25-30, Medellín',
                'active' => true
            ],
            [
                'name' => 'Carlos Rodríguez',
                'email' => 'carlos.rodriguez@empresa.com',
                'phone' => '3009876543',
                'address' => 'Avenida 15 #80-45, Cali',
                'active' => true
            ],
            [
                'name' => 'Ana López',
                'email' => 'ana.lopez@empresa.com',
                'phone' => '3005432167',
                'address' => 'Calle 70 #12-34, Barranquilla',
                'active' => true
            ]
        ];

        foreach ($sellers as $seller) {
            \App\Models\Seller::create($seller);
        }
    }
}
