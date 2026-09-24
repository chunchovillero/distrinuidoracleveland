<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Operaciones exclusivas del superadministrador.
        Gate::define('manage-admin', function ($user) {
            return $user->isSuperAdmin();
        });

        Gate::define('manage-system', function ($user) {
            return $user->isSuperAdmin();
        });

        // Gate para gestión de usuarios
        Gate::define('manage-users', function ($user) {
            return $user->isSuperAdmin();
        });

        // Gate para reportes avanzados
        Gate::define('view-advanced-reports', function ($user) {
            return $user->isAdmin();
        });

        // Gate general para verificar si es admin
        Gate::define('is-admin', function ($user) {
            return $user->isAdmin();
        });

        // Gates dinámicos para permisos específicos - definir dinámicamente todos
        $permissions = \App\Models\UserPermission::getAvailablePermissions();
        
        foreach ($permissions as $permissionKey => $permissionName) {
            // Convertir underscore a dash para gates (Laravel convention)
            $gateKey = str_replace('_', '-', $permissionKey);
            
            Gate::define($gateKey, function ($user) use ($permissionKey) {
                return $user->hasPermission($permissionKey);
            });
        }
    }
}
