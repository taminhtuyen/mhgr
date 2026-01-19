<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShippingShipment extends Model
{
    use HasFactory;

    protected $table = 'shipping_shipments';

    protected $fillable = [
        'order_id',
        'warehouse_id',
        'shipping_method',
        'shipping_partner_id',
        'driver_id',
        'tracking_code',
        'cod_amount',
        'shipping_fee',
        'status',
        'proof_image',
        'estimated_delivery_at',
    ];

    protected $casts = [
        'estimated_delivery_at' => 'datetime',
        'cod_amount' => 'decimal:2',
        'shipping_fee' => 'decimal:2',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(ShippingDriver::class, 'driver_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(ShippingShipmentItem::class, 'shipment_id');
    }
}