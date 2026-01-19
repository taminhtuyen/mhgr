<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Delivery extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'deliveries';

    protected $fillable = [
        'order_id',
        'shipper_id',
        'tracking_code',
        'status',
        'cod_amount',
        'shipping_fee',
        'note',
        'delivered_at',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function shipper(): BelongsTo
    {
        return $this->belongsTo(User::class, 'shipper_id');
    }
}