<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Seller extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    /**
     * Obtener las ventas del vendedor
     */
    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    /**
     * Calcular comisiones totales en un periodo
     */
    public function totalCommissions($startDate = null, $endDate = null)
    {
        $query = $this->sales()->where('status', 'completed');
        
        if ($startDate) {
            $query->where('sale_date', '>=', $startDate);
        }
        
        if ($endDate) {
            $query->where('sale_date', '<=', $endDate);
        }
        
        return $query->sum('total_commission');
    }
}
