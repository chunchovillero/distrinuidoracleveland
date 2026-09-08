<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                'name' => 'Empresa ABC S.A.S.',
                'email' => 'contacto@empresaabc.com',
                'phone' => '3201234567',
                'address' => 'Zona Industrial, Calle 80 #45-23, Bogotá',
                'document_type' => 'NIT',
                'document_number' => '900123456-7',
                'active' => true
            ],
            [
                'name' => 'Pedro Martínez',
                'email' => 'pedro.martinez@gmail.com',
                'phone' => '3157654321',
                'address' => 'Carrera 45 #67-89, Medellín',
                'document_type' => 'CC',
                'document_number' => '12345678',
                'active' => true
            ],
            [
                'name' => 'Distribuidora XYZ Ltda.',
                'email' => 'ventas@distribuidoraxyz.com',
                'phone' => '3109876543',
                'address' => 'Centro Comercial Plaza, Local 205, Cali',
                'document_type' => 'NIT',
                'document_number' => '800987654-3',
                'active' => true
            ],
            [
                'name' => 'Laura Fernández',
                'email' => 'laura.fernandez@hotmail.com',
                'phone' => '3185432167',
                'address' => 'Barrio El Prado, Calle 72 #34-56, Barranquilla',
                'document_type' => 'CC',
                'document_number' => '87654321',
                'active' => true
            ],
            [
                'name' => 'Comercializadora 123',
                'email' => 'info@comercializadora123.com',
                'phone' => '3123456789',
                'address' => 'Sector Norte, Avenida 30 #12-45, Bucaramanga',
                'document_type' => 'NIT',
                'document_number' => '700123987-4',
                'active' => true
            ],
            [
                'name' => 'Roberto Silva',
                'email' => 'roberto.silva@outlook.com',
                'phone' => '3167890123',
                'address' => 'Barrio La Esperanza, Carrera 25 #78-90, Pereira',
                'document_type' => 'CC',
                'document_number' => '45678912',
                'active' => true
            ]
        ];

        foreach ($customers as $customer) {
            \App\Models\Customer::create($customer);
        }
    }
}
