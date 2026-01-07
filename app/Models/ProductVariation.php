<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class ProductVariation extends Model
{
    use HasFactory;

    protected $table = 'product_variations';

    protected $fillable = [
        'product_id',
        'sku',
        'name',
        'quantity',
        'status',
        'price',
        'price_sale',
        'weight',
        'image_url',
        'original_variation_id',
    ];

    /**
     * Quan hệ: Thuộc về sản phẩm cha.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Quan hệ Đa hình: Biến thể cũng có thể có ảnh riêng.
     */
    public function images(): MorphToMany
    {
        return $this->morphToMany(Image::class, 'imageable', 'imageables', 'imageable_id', 'image_id')
            ->withPivot('position', 'meta');
    }

    /**
     * Quan hệ: Tồn kho của biến thể này.
     */
    public function inventoryStocks(): HasMany
    {
        return $this->hasMany(InventoryStock::class, 'product_variation_id');
    }
}
