<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'rut',
        'email',
        'phone',
        'celular',
        'address',
        'direccion',
        'localidad',
        'transporte',
        'document_type',
        'document_number',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    /**
     * Obtener las ventas del cliente
     */
    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    /**
     * Obtener el total de compras del cliente
     */
    public function totalPurchases()
    {
        return $this->sales()->where('status', 'completed')->sum('total');
    }

    /**
     * Obtener la última venta del cliente
     */
    public function lastSale()
    {
        return $this->sales()->latest('sale_date')->first();
    }
}
