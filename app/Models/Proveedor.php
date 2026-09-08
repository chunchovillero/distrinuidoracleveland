<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proveedor extends Model
{
    protected $table = 'proveedores';
    
    protected $fillable = [
        'nombre',
        'descripcion',
        'contacto',
        'telefono',
        'email',
        'direccion',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    /**
     * Relación con productos
     */
    public function productos(): HasMany
    {
        return $this->hasMany(Product::class, 'proveedor_id');
    }

    /**
     * Scope para proveedores activos
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
}
