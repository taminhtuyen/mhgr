<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PromotionInventory extends Model
{
    use HasFactory;

    protected $table = 'promotion_inventory';

    protected $fillable = [
        'promotion_id',
        'product_id',
        'total_quantity',
        'sold_quantity',
        'reserved_quantity',
    ];

    protected $casts = [
    ];

    public function promotion(): BelongsTo
    {
        return $this->belongsTo(Promotion::class, 'promotion_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
