<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeliveryAttempt extends Model
{
    use HasFactory;

    protected $table = 'delivery_attempts';

    protected $fillable = [
        'shipment_id',
        'driver_id',
        'attempt_number',
        'attempted_at',
        'status',
        'failure_reason',
        'notes',
        'proof_image',
    ];

    protected $casts = [
        'attempted_at' => 'datetime',
    ];

    public function shipment(): BelongsTo
    {
        return $this->belongsTo(ShippingShipment::class, 'shipment_id');
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(ShippingDriver::class, 'driver_id');
    }
}
