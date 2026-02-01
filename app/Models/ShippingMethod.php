<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShippingMethod extends Model
{
    use HasFactory;

    protected $table = 'shipping_methods';

    protected $fillable = [
        'name',
        'code',
        'description',
        'base_cost',
        'cost_per_kg',
        'cost_per_km',
        'estimated_delivery_days',
        'status',
    ];

    protected $casts = [
    ];
}
