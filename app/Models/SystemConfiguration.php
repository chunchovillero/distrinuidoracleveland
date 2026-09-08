<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SystemConfiguration extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
        'description'
    ];

    protected $casts = [
        'value' => 'string'
    ];

    /**
     * Get a configuration value by key
     */
    public static function getValue($key, $default = null)
    {
        $config = self::where('key', $key)->first();
        return $config ? $config->value : $default;
    }

    /**
     * Establecer un valor de configuración
     */
    public static function setValue($key, $value, $group = 'general', $label = null, $type = 'text')
    {
        return self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'group' => $group,
                'label' => $label ?? $key,
                'type' => $type
            ]
        );
    }

    /**
     * Get all configurations grouped by group
     */
    public static function getGrouped()
    {
        return self::all()->groupBy('group');
    }

    /**
     * Get image URL for image type configurations
     */
    public function getImageUrlAttribute()
    {
        if ($this->type === 'image' && $this->value) {
            return Storage::url($this->value);
        }
        return null;
    }

    /**
     * Get boolean value for boolean type configurations
     */
    public function getBooleanValueAttribute()
    {
        if ($this->type === 'boolean') {
            return filter_var($this->value, FILTER_VALIDATE_BOOLEAN);
        }
        return null;
    }

    /**
     * Get JSON value for json type configurations
     */
    public function getJsonValueAttribute()
    {
        if ($this->type === 'json') {
            return json_decode($this->value, true);
        }
        return null;
    }
}
