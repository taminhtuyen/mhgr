<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingProfit extends Model
{
    use HasFactory;

    protected $table = 'booking_profit';

    protected $fillable = [
        'order_id',
        'total_revenue',
        'total_cogs',
        'total_shipping_cost',
        'total_commission',
        'total_discount',
        'net_profit',
        'profit_margin',
    ];

    protected $casts = [
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
