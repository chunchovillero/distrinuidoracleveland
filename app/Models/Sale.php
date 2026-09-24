<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    protected $fillable = [
        'invoice_number',
        'customer_id',
        'seller_id',
        'created_by_user_id',
        'subtotal',
        'tax',
        'total',
        'total_commission',
        'payment_method',
        'dispatch_type_id',
        'dispatch_address',
        'notes',
        'status',
        'sale_date'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
        'total_commission' => 'decimal:2',
        'sale_date' => 'date'
    ];

    /**
     * Obtener el cliente de la venta
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Obtener el vendedor de la venta
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function dispatchType(): BelongsTo
    {
        return $this->belongsTo(DispatchType::class);
    }

    /**
     * Obtener los detalles de la venta
     */
    public function saleDetails(): HasMany
    {
        return $this->hasMany(SaleDetail::class);
    }

    /**
     * Generar número de venta automático
     */
    public static function generateInvoiceNumber()
    {
        $lastSale = self::latest('id')->first();
        $nextNumber = $lastSale ? $lastSale->id + 1 : 1;
        return 'VTA-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Calcular totales de la venta
     */
    public function calculateTotals()
    {
        $subtotal = $this->saleDetails()->sum('subtotal');
        $totalCommission = $this->saleDetails()->sum('commission');
        
        $this->update([
            'subtotal' => $subtotal,
            'total' => $subtotal + $this->tax,
            'total_commission' => $totalCommission
        ]);
    }
}
