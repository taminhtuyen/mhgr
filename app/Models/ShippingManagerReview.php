<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShippingManagerReview extends Model
{
    use HasFactory;

    protected $table = 'shipping_manager_reviews';

    protected $fillable = [
        'manager_id',
        'driver_id',
        'shipment_id',
        'rating',
        'comment',
        'review_date',
    ];

    protected $casts = [
        'review_date' => 'datetime',
    ];

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(ShippingDriver::class, 'driver_id');
    }

    public function shipment(): BelongsTo
    {
        return $this->belongsTo(ShippingShipment::class, 'shipment_id');
    }
}
