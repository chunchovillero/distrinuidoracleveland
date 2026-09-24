<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Usuario Administrador
        User::updateOrCreate(
            ['email' => 'admin@pos.com'],
            [
                'name' => 'Administrador del Sistema',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'active' => true,
                'phone' => '+56912345678',
                'address' => 'Oficina Central'
            ]
        );

        // Usuario Gerente
        User::updateOrCreate(
            ['email' => 'gerente@pos.com'],
            [
                'name' => 'Gerente General',
                'password' => Hash::make('gerente123'),
                'role' => 'manager',
                'active' => true,
                'phone' => '+56987654321',
                'address' => 'Oficina Gerencia'
            ]
        );

        // Usuario Vendedor
        User::updateOrCreate(
            ['email' => 'vendedor@pos.com'],
            [
                'name' => 'Juan Pérez',
                'password' => Hash::make('vendedor123'),
                'role' => 'seller',
                'active' => true,
                'phone' => '+56911111111',
                'address' => 'Sala de Ventas'
            ]
        );

        // Usuario Regular
        User::updateOrCreate(
            ['email' => 'usuario@pos.com'],
            [
                'name' => 'María González',
                'password' => Hash::make('usuario123'),
                'role' => 'user',
                'active' => true,
                'phone' => '+56922222222',
                'address' => 'Oficina General'
            ]
        );

        // Usuario Vendedor Adicional
        User::updateOrCreate(
            ['email' => 'carlos@pos.com'],
            [
                'name' => 'Carlos Silva',
                'password' => Hash::make('carlos123'),
                'role' => 'seller',
                'active' => true,
                'phone' => '+56933333333',
                'address' => 'Sucursal Norte'
            ]
        );

        $this->command->info('Usuarios creados exitosamente:');
        $this->command->line('- Admin: admin@pos.com / admin123');
        $this->command->line('- Gerente: gerente@pos.com / gerente123');
        $this->command->line('- Vendedor: vendedor@pos.com / vendedor123');
        $this->command->line('- Usuario: usuario@pos.com / usuario123');
        $this->command->line('- Vendedor 2: carlos@pos.com / carlos123');
    }
}
