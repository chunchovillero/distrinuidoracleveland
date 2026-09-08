<?php

namespace App\Http\Controllers;

use App\Models\SystemConfiguration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SystemConfigurationController extends Controller
{
    /**
     * Display the system configuration form
     */
    public function index()
    {
        $configurations = SystemConfiguration::all()->groupBy('group');
        
        // Asegurar que existan los grupos básicos
        $defaultGroups = ['branding', 'appearance', 'general', 'features'];
        foreach ($defaultGroups as $group) {
            if (!$configurations->has($group)) {
                $configurations[$group] = collect();
            }
        }
        
        return view('admin.configuration.index', compact('configurations'));
    }

    /**
     * Update system configurations
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png|max:512',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
        // Manejar subida de logo
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = 'logo_' . time() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('system'), $logoName);
            SystemConfiguration::setValue('logo', 'system/' . $logoName);
        }

        // Manejar subida de favicon
        if ($request->hasFile('favicon')) {
            $favicon = $request->file('favicon');
            $faviconName = 'favicon_' . time() . '.' . $favicon->getClientOriginalExtension();
            $favicon->move(public_path('system'), $faviconName);
            SystemConfiguration::setValue('favicon', 'system/' . $faviconName);
        }            // Handle other configurations
            $configurations = [
                // Branding
                'company_name' => ['value' => $request->company_name, 'type' => 'text', 'group' => 'branding', 'label' => 'Nombre de la Empresa'],
                'company_tagline' => ['value' => $request->company_tagline, 'type' => 'text', 'group' => 'branding', 'label' => 'Eslogan de la Empresa'],
                
                // Colors
                'primary_color' => ['value' => $request->primary_color, 'type' => 'color', 'group' => 'appearance', 'label' => 'Color Primario'],
                'secondary_color' => ['value' => $request->secondary_color, 'type' => 'color', 'group' => 'appearance', 'label' => 'Color Secundario'],
                'accent_color' => ['value' => $request->accent_color, 'type' => 'color', 'group' => 'appearance', 'label' => 'Color de Acento'],
                'sidebar_color' => ['value' => $request->sidebar_color, 'type' => 'color', 'group' => 'appearance', 'label' => 'Color del Sidebar'],
                
                // General settings
                'system_name' => ['value' => $request->system_name, 'type' => 'text', 'group' => 'general', 'label' => 'Nombre del Sistema'],
                'footer_text' => ['value' => $request->footer_text, 'type' => 'text', 'group' => 'general', 'label' => 'Texto del Footer'],
                'timezone' => ['value' => $request->timezone, 'type' => 'text', 'group' => 'general', 'label' => 'Zona Horaria'],
                'currency_symbol' => ['value' => $request->currency_symbol, 'type' => 'text', 'group' => 'general', 'label' => 'Símbolo de Moneda'],
                
                // Features
                'enable_whatsapp' => ['value' => $request->has('enable_whatsapp') ? '1' : '0', 'type' => 'boolean', 'group' => 'features', 'label' => 'Habilitar WhatsApp'],
                'enable_catalog' => ['value' => $request->has('enable_catalog') ? '1' : '0', 'type' => 'boolean', 'group' => 'features', 'label' => 'Habilitar Catálogo Público'],
                'maintenance_mode' => ['value' => $request->has('maintenance_mode') ? '1' : '0', 'type' => 'boolean', 'group' => 'features', 'label' => 'Modo Mantenimiento'],
            ];

            foreach ($configurations as $key => $config) {
                if ($config['value'] !== null) {
                    SystemConfiguration::updateOrCreate(
                        ['key' => $key],
                        [
                            'value' => $config['value'],
                            'type' => $config['type'],
                            'group' => $config['group'],
                            'label' => $config['label']
                        ]
                    );
                }
            }

            return redirect()->back()->with('success', 'Configuraciones actualizadas correctamente');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar configuraciones: ' . $e->getMessage());
        }
    }

    /**
     * Initialize default configurations
     */
    public static function initializeDefaults()
    {
        $defaults = [
            // Branding
            ['key' => 'company_name', 'value' => 'Mi Empresa', 'type' => 'text', 'group' => 'branding', 'label' => 'Nombre de la Empresa'],
            ['key' => 'company_tagline', 'value' => 'Tu mejor opción', 'type' => 'text', 'group' => 'branding', 'label' => 'Eslogan de la Empresa'],
            ['key' => 'logo', 'value' => null, 'type' => 'image', 'group' => 'branding', 'label' => 'Logo de la Empresa'],
            ['key' => 'favicon', 'value' => null, 'type' => 'image', 'group' => 'branding', 'label' => 'Favicon'],
            
            // Appearance
            ['key' => 'primary_color', 'value' => '#007bff', 'type' => 'color', 'group' => 'appearance', 'label' => 'Color Primario'],
            ['key' => 'secondary_color', 'value' => '#6c757d', 'type' => 'color', 'group' => 'appearance', 'label' => 'Color Secundario'],
            ['key' => 'accent_color', 'value' => '#28a745', 'type' => 'color', 'group' => 'appearance', 'label' => 'Color de Acento'],
            ['key' => 'sidebar_color', 'value' => '#343a40', 'type' => 'color', 'group' => 'appearance', 'label' => 'Color del Sidebar'],
            
            // General
            ['key' => 'system_name', 'value' => 'Sistema POS', 'type' => 'text', 'group' => 'general', 'label' => 'Nombre del Sistema'],
            ['key' => 'footer_text', 'value' => '© 2025 Sistema POS. Todos los derechos reservados.', 'type' => 'text', 'group' => 'general', 'label' => 'Texto del Footer'],
            ['key' => 'timezone', 'value' => 'America/Santiago', 'type' => 'text', 'group' => 'general', 'label' => 'Zona Horaria'],
            ['key' => 'currency_symbol', 'value' => '$', 'type' => 'text', 'group' => 'general', 'label' => 'Símbolo de Moneda'],
            
            // Features
            ['key' => 'enable_whatsapp', 'value' => '1', 'type' => 'boolean', 'group' => 'features', 'label' => 'Habilitar WhatsApp'],
            ['key' => 'enable_catalog', 'value' => '1', 'type' => 'boolean', 'group' => 'features', 'label' => 'Habilitar Catálogo Público'],
            ['key' => 'maintenance_mode', 'value' => '0', 'type' => 'boolean', 'group' => 'features', 'label' => 'Modo Mantenimiento'],
        ];

        foreach ($defaults as $default) {
            SystemConfiguration::firstOrCreate(
                ['key' => $default['key']],
                $default
            );
        }
    }
}
