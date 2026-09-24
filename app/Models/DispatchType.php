<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DispatchType extends Model
{
    protected $fillable = ['name', 'requires_address', 'active'];

    protected $casts = [
        'requires_address' => 'boolean',
        'active' => 'boolean',
    ];

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }
}
