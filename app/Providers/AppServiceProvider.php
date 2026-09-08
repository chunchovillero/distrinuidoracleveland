<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use App\Listeners\UpdateLastLogin;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        
        // Configurar vista de paginación personalizada para AdminLTE
        Paginator::defaultView('pagination::adminlte');
        Paginator::defaultSimpleView('pagination::simple-bootstrap-4');
        
        // Registrar listener para actualizar último login
        Event::listen(Login::class, UpdateLastLogin::class);
    }
}
