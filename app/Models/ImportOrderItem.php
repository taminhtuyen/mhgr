<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImportOrderItem extends Model
{
    use HasFactory;

    protected $table = 'import_order_items';
    public $timestamps = false;

    protected $fillable = [
        'import_order_id',
        'product_id',
        'product_variation_id',
        'quantity',
        'import_price',
    ];

    public function importOrder(): BelongsTo
    {
        return $this->belongsTo(ImportOrder::class, 'import_order_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function productVariation(): BelongsTo
    {
        return $this->belongsTo(ProductVariation::class, 'product_variation_id');
    }
}