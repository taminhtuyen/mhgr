<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


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

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}