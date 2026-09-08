<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPermission extends Model
{
    protected $fillable = [
        'user_id',
        'permission_key',
        'granted'
    ];

    protected $casts = [
        'granted' => 'boolean'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Permisos disponibles en el sistema
     */
    public static function getAvailablePermissions(): array
    {
        return [
            // Dashboard
            'view_dashboard' => 'Ver Dashboard',
            
            // Productos
            'view_products' => 'Ver Productos',
            'create_products' => 'Crear Productos',
            'edit_products' => 'Editar Productos',
            'delete_products' => 'Eliminar Productos',
            'toggle_products' => 'Activar/Desactivar Productos',
            
            // Clientes
            'view_customers' => 'Ver Clientes',
            'create_customers' => 'Crear Clientes',
            'edit_customers' => 'Editar Clientes',
            'delete_customers' => 'Eliminar Clientes',
            'toggle_customers' => 'Activar/Desactivar Clientes',
            
            // Vendedores
            'view_sellers' => 'Ver Vendedores',
            'create_sellers' => 'Crear Vendedores',
            'edit_sellers' => 'Editar Vendedores',
            'delete_sellers' => 'Eliminar Vendedores',
            'toggle_sellers' => 'Activar/Desactivar Vendedores',
            
            // Categorías
            'view_categories' => 'Ver Categorías',
            'create_categories' => 'Crear Categorías',
            'edit_categories' => 'Editar Categorías',
            'delete_categories' => 'Eliminar Categorías',
            'toggle_categories' => 'Activar/Desactivar Categorías',
            
            // Ventas
            'view_sales' => 'Ver Ventas',
            'create_sales' => 'Crear Ventas',
            'duplicate_sales' => 'Duplicar Ventas',
            'cancel_sales' => 'Cancelar Ventas',
            'delete_sales' => 'Eliminar Ventas',
            'export_sales' => 'Exportar Ventas a Excel',
            
            // Reportes
            'view_reports_sales' => 'Ver Reportes de Ventas',
            'view_reports_inventory' => 'Ver Reportes de Inventario',
            'view_reports_customers' => 'Ver Reportes de Clientes',
            'view_reports_monthly' => 'Ver Reportes Mensuales',
            'view_reports_commissions' => 'Ver Reportes de Comisiones',
            'view_reports_calidad' => 'Ver Reportes de Calidad',
        ];
    }
    
    /**
     * Agrupar permisos por categorías para la interfaz
     */
    public static function getPermissionsByCategory(): array
    {
        return [
            'Dashboard' => [
                'view_dashboard' => 'Ver Dashboard'
            ],
            'Productos' => [
                'view_products' => 'Ver Productos',
                'create_products' => 'Crear Productos',
                'edit_products' => 'Editar Productos',
                'delete_products' => 'Eliminar Productos',
                'toggle_products' => 'Activar/Desactivar Productos',
            ],
            'Clientes' => [
                'view_customers' => 'Ver Clientes',
                'create_customers' => 'Crear Clientes',
                'edit_customers' => 'Editar Clientes',
                'delete_customers' => 'Eliminar Clientes',
                'toggle_customers' => 'Activar/Desactivar Clientes',
            ],
            'Vendedores' => [
                'view_sellers' => 'Ver Vendedores',
                'create_sellers' => 'Crear Vendedores',
                'edit_sellers' => 'Editar Vendedores',
                'delete_sellers' => 'Eliminar Vendedores',
                'toggle_sellers' => 'Activar/Desactivar Vendedores',
            ],
            'Categorías' => [
                'view_categories' => 'Ver Categorías',
                'create_categories' => 'Crear Categorías',
                'edit_categories' => 'Editar Categorías',
                'delete_categories' => 'Eliminar Categorías',
                'toggle_categories' => 'Activar/Desactivar Categorías',
            ],
            'Ventas' => [
                'view_sales' => 'Ver Ventas',
                'create_sales' => 'Crear Ventas',
                'duplicate_sales' => 'Duplicar Ventas',
                'cancel_sales' => 'Cancelar Ventas',
                'delete_sales' => 'Eliminar Ventas',
                'export_sales' => 'Exportar Ventas a Excel',
            ],
            'Reportes' => [
                'view_reports_sales' => 'Ver Reportes de Ventas',
                'view_reports_inventory' => 'Ver Reportes de Inventario', 
                'view_reports_customers' => 'Ver Reportes de Clientes',
                'view_reports_monthly' => 'Ver Reportes Mensuales',
                'view_reports_commissions' => 'Ver Reportes de Comisiones',
                'view_reports_calidad' => 'Ver Reportes de Calidad',
            ]
        ];
    }
}
