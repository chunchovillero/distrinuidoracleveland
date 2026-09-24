<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Crear o sincronizar exclusivamente la cuenta superadministradora.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'superadmin@pos.com'],
            [
                'name' => 'Superadministrador del Sistema',
                'password' => Hash::make('superadmin123'),
                'role' => 'superadmin',
                'active' => true,
                'phone' => '+56900000000',
                'address' => 'Oficina Central',
            ]
        );

        $this->command->info('Superadmin creado: superadmin@pos.com / superadmin123');
    }
}
