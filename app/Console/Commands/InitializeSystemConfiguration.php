<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SystemConfiguration;

class InitializeSystemConfiguration extends Command
{
    protected $signature = 'system:init-config';
    protected $description = 'Initialize system configurations with default values';

    public function handle()
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
            SystemConfiguration::updateOrCreate(
                ['key' => $config['key']],
                $config
            );
            $this->info("Configuración '{$config['key']}' inicializada");
        }

        $this->info('Configuraciones del sistema inicializadas exitosamente');
        return 0;
    }
}
