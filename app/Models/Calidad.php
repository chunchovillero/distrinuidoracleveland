<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Calidad extends Model
{
    protected $table = 'calidad';
    
    protected $fillable = [
        'nombre'
    ];

    /**
     * Obtener los productos de esta calidad
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
