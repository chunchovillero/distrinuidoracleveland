<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'sku',
        'price',
        'stock',
        'kilos',
        'commission',
        'image',
        'category_id',
        'calidad_id',
        'proveedor_id',
        'active',
        'show_in_catalog'
    ];

    protected $casts = [
        'active' => 'boolean',
        'show_in_catalog' => 'boolean',
        'price' => 'decimal:2',
        'cost' => 'decimal:2',
        'commission' => 'decimal:2',
        'kilos' => 'decimal:3'
    ];

    /**
     * Obtener la categoría del producto
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Obtener la calidad del producto
     */
    public function calidad(): BelongsTo
    {
        return $this->belongsTo(Calidad::class);
    }

    /**
     * Obtener el proveedor del producto
     */
    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class);
    }

    /**
     * Obtener los detalles de venta del producto
     */
    public function saleDetails(): HasMany
    {
        return $this->hasMany(SaleDetail::class);
    }

    /**
     * Reducir stock del producto
     */
    public function reduceStock($quantity)
    {
        if ($this->stock >= $quantity) {
            $this->decrement('stock', $quantity);
            return true;
        }
        return false;
    }

    /**
     * Aumentar stock del producto
     */
    public function addStock($quantity)
    {
        $this->increment('stock', $quantity);
    }

    /**
     * Verificar si está bajo en stock
     */
    public function isLowStock()
    {
        return $this->stock <= $this->min_stock;
    }

    /**
     * Obtener productos para el catálogo público
     */
    public static function forCatalog()
    {
        return self::where('active', true)
                   ->where('show_in_catalog', true)
                   ->where('stock', '>', 0);
    }
}
