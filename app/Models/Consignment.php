<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Consignment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'consignment_orders';

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'agreed_price',
        'status',
        'note',
        'expired_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
