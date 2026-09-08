<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Calidad;

class CalidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $calidades = [
            '1 ERA',
            '1° PREMIUM',
            '1ERA-2DA',
            'PREMIUM'
        ];

        foreach ($calidades as $calidad) {
            Calidad::create([
                'nombre' => $calidad
            ]);
        }
    }
}
