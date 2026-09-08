<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdditionalSellersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sellers = [
            [
                'name' => 'Ana María González',
                'email' => 'ana.gonzalez@pos.com',
                'password' => Hash::make('vendedor123'),
                'role' => 'seller',
                'phone' => '+56987654321',
                'address' => 'Av. Providencia 1234, Santiago',
                'active' => true,
            ],
            [
                'name' => 'Roberto Silva',
                'email' => 'roberto.silva@pos.com',
                'password' => Hash::make('vendedor123'),
                'role' => 'seller',
                'phone' => '+56912345678',
                'address' => 'Calle Principal 567, Valparaíso',
                'active' => true,
            ],
            [
                'name' => 'Carmen López',
                'email' => 'carmen.lopez@pos.com',
                'password' => Hash::make('vendedor123'),
                'role' => 'seller',
                'phone' => '+56998765432',
                'address' => 'Av. Brasil 890, Valparaíso',
                'active' => true,
            ],
            [
                'name' => 'Diego Morales',
                'email' => 'diego.morales@pos.com',
                'password' => Hash::make('vendedor123'),
                'role' => 'seller',
                'phone' => '+56976543210',
                'address' => 'Las Condes 456, Santiago',
                'active' => true,
            ],
            [
                'name' => 'Patricia Rojas',
                'email' => 'patricia.rojas@pos.com',
                'password' => Hash::make('vendedor123'),
                'role' => 'seller',
                'phone' => '+56965432109',
                'address' => 'Ñuñoa 789, Santiago',
                'active' => true,
            ],
            [
                'name' => 'Fernando Castro',
                'email' => 'fernando.castro@pos.com',
                'password' => Hash::make('vendedor123'),
                'role' => 'seller',
                'phone' => '+56954321098',
                'address' => 'Maipú 123, Santiago',
                'active' => true,
            ],
            [
                'name' => 'Mónica Herrera',
                'email' => 'monica.herrera@pos.com',
                'password' => Hash::make('vendedor123'),
                'role' => 'seller',
                'phone' => '+56943210987',
                'address' => 'San Miguel 456, Santiago',
                'active' => true,
            ],
            [
                'name' => 'Andrés Vargas',
                'email' => 'andres.vargas@pos.com',
                'password' => Hash::make('vendedor123'),
                'role' => 'seller',
                'phone' => '+56932109876',
                'address' => 'La Serena 789, IV Región',
                'active' => true,
            ],
            [
                'name' => 'Lucía Mendoza',
                'email' => 'lucia.mendoza@pos.com',
                'password' => Hash::make('vendedor123'),
                'role' => 'seller',
                'phone' => '+56921098765',
                'address' => 'Concepción 123, VIII Región',
                'active' => true,
            ],
            [
                'name' => 'Raúl Paredes',
                'email' => 'raul.paredes@pos.com',
                'password' => Hash::make('vendedor123'),
                'role' => 'seller',
                'phone' => '+56910987654',
                'address' => 'Temuco 456, IX Región',
                'active' => true,
            ],
        ];

        foreach ($sellers as $seller) {
            User::create($seller);
        }

        $this->command->info('10 vendedores adicionales creados exitosamente.');
    }
}