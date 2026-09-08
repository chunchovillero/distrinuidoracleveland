<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleDetail extends Model
{
    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'unit_price',
        'commission_percentage',
        'commission_amount',
        'subtotal'
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'commission_percentage' => 'decimal:2',
        'commission_amount' => 'decimal:2',
        'subtotal' => 'decimal:2'
    ];

    /**
     * Obtener la venta asociada
     */
    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    /**
     * Obtener el producto asociado
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Calcular subtotal automáticamente
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($saleDetail) {
            $saleDetail->subtotal = $saleDetail->quantity * $saleDetail->unit_price;
        });
    }
}
