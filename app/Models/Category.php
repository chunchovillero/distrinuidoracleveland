<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    /**
     * Obtener los productos de la categoría
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Obtener productos activos de la categoría
     */
    public function activeProducts(): HasMany
    {
        return $this->hasMany(Product::class)->where('active', true);
    }
}
