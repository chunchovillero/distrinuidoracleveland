<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpiar la tabla customers primero
        Customer::truncate();
        
        $csvFile = database_path('seeders/customers_data.csv');
        
        if (file_exists($csvFile)) {
            $file = fopen($csvFile, 'r');
            $header = fgetcsv($file); // Skip header row
            
            while (($row = fgetcsv($file)) !== false) {
                Customer::create([
                    'name' => $row[0],
                    'rut' => $row[1],
                    'celular' => $row[2],
                    'address' => $row[3],
                    'direccion' => $row[3],
                    'localidad' => $row[4],
                    'transporte' => $row[5],
                ]);
            }
            
            fclose($file);
        } else {
            $this->command->error('Customer data CSV file not found!');
        }
    }
}
