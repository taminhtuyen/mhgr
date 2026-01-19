<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class OrderTransaction extends Model
{
    use HasFactory;

    protected $table = 'order_transactions';

    protected $fillable = [
        'order_id',
        'user_id',
        'transaction_code',
        'amount',
        'payment_method',
        'status',
        'content',
        'gateway_response',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}