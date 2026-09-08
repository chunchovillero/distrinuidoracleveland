<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DefaultUserPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Otorgar permisos básicos al usuario de prueba
        $user = User::where('email', 'usuario.prueba@pos.com')->first();
        
        if ($user) {
            // Permisos básicos por defecto
            $user->grantPermission('view_dashboard');
            $user->grantPermission('view_products');
            $user->grantPermission('create_products');
            $user->grantPermission('edit_products');
            $user->grantPermission('delete_products');
            $user->grantPermission('toggle_products');
            $user->grantPermission('view_sales');
            $user->grantPermission('view_customers');
            $user->grantPermission('view_categories');
            $user->grantPermission('create_categories');
            $user->grantPermission('edit_categories');
            $user->grantPermission('delete_categories');
            $user->grantPermission('view_reports_sales');
            
            echo "Permisos completos otorgados a {$user->name}\n";
        }
    }
}