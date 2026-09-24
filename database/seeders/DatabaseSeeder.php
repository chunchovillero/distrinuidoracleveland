<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ejecutar seeders en orden
        $this->call([
            SuperAdminSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            CalidadSeeder::class,
            SellerSeeder::class,
            CustomerSeeder::class,
            ProductSeeder::class,
            AdditionalSellersSeeder::class,
            SalesDataSeeder::class,
        ]);
    }
}
