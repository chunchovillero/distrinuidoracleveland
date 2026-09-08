<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Proveedor;

class ProveedoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $proveedores = [
            ['nombre' => 'UFO', 'descripcion' => 'Proveedor UFO', 'activo' => true],
            ['nombre' => 'CONNOR', 'descripcion' => 'Proveedor CONNOR', 'activo' => true],
            ['nombre' => 'NELSON', 'descripcion' => 'Proveedor NELSON', 'activo' => true],
            ['nombre' => 'SELIN HOGAR', 'descripcion' => 'Proveedor SELIN para artículos del hogar', 'activo' => true],
            ['nombre' => 'SELIN VESTUARIO', 'descripcion' => 'Proveedor SELIN para vestuario', 'activo' => true],
        ];

        foreach ($proveedores as $proveedor) {
            Proveedor::create($proveedor);
        }
    }
}
