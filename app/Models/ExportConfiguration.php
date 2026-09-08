<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExportConfiguration extends Model
{
    protected $fillable = [
        'export_type',
        'selected_fields',
        'is_default'
    ];

    protected $casts = [
        'selected_fields' => 'array',
        'is_default' => 'boolean'
    ];

    /**
     * Obtener la configuración por defecto para un tipo de exportación
     */
    public static function getDefaultConfiguration($exportType)
    {
        return self::where('export_type', $exportType)
                   ->where('is_default', true)
                   ->first();
    }

    /**
     * Establecer una configuración como por defecto
     */
    public function setAsDefault()
    {
        // Primero, quitar el estado por defecto de otras configuraciones del mismo tipo
        self::where('export_type', $this->export_type)
            ->where('id', '!=', $this->id)
            ->update(['is_default' => false]);

        // Establecer esta configuración como por defecto
        $this->update(['is_default' => true]);
    }
}
