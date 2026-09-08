<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\SystemConfiguration;

class SystemConfigurationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        try {
            // Solo cargar configuraciones si la tabla existe
            if (\Schema::hasTable('system_configurations')) {
                $configurations = SystemConfiguration::all()->pluck('value', 'key');
                
                // Compartir configuraciones con todas las vistas
                View::share('systemConfig', $configurations);
                
                // Configurar valores por defecto si no existen
                $this->setDefaultConfigurations();
            }
        } catch (\Exception $e) {
            // Fallar silenciosamente si hay problemas con la base de datos
        }
    }

    /**
     * Establecer configuraciones por defecto
     */
    private function setDefaultConfigurations()
    {
        $defaults = [
            // Branding
            ['key' => 'company_name', 'value' => 'Sistema POS', 'group' => 'branding', 'label' => 'Nombre de la Empresa', 'type' => 'text'],
            ['key' => 'company_email', 'value' => 'info@sistemapos.com', 'group' => 'branding', 'label' => 'Email de la Empresa', 'type' => 'email'],
            ['key' => 'company_phone', 'value' => '(123) 456-7890', 'group' => 'branding', 'label' => 'Teléfono de la Empresa', 'type' => 'text'],
            ['key' => 'company_address', 'value' => 'Dirección de la empresa', 'group' => 'branding', 'label' => 'Dirección de la Empresa', 'type' => 'textarea'],
            
            // Appearance
            ['key' => 'primary_color', 'value' => '#007bff', 'group' => 'appearance', 'label' => 'Color Primario', 'type' => 'color'],
            ['key' => 'secondary_color', 'value' => '#6c757d', 'group' => 'appearance', 'label' => 'Color Secundario', 'type' => 'color'],
            ['key' => 'accent_color', 'value' => '#28a745', 'group' => 'appearance', 'label' => 'Color de Acento', 'type' => 'color'],
            
            // General
            ['key' => 'show_logo', 'value' => 'true', 'group' => 'general', 'label' => 'Mostrar Logo', 'type' => 'boolean'],
            
            // Features
            ['key' => 'enable_notifications', 'value' => 'true', 'group' => 'features', 'label' => 'Activar Notificaciones', 'type' => 'boolean'],
            ['key' => 'enable_dark_mode', 'value' => 'false', 'group' => 'features', 'label' => 'Modo Oscuro', 'type' => 'boolean'],
            ['key' => 'maintenance_mode', 'value' => 'false', 'group' => 'features', 'label' => 'Modo Mantenimiento', 'type' => 'boolean'],
        ];

        foreach ($defaults as $config) {
            if (!SystemConfiguration::where('key', $config['key'])->exists()) {
                SystemConfiguration::create($config);
            }
        }
    }
}
