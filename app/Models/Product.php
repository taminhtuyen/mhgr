<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'category_id',
        'original_product_id',
        'name',
        'description',
        'link_video',
        'status',
        'is_pin',
        'point_purchase',
        'slug',
        'product_quantity',
        'unit',
        'must_login',
        'purchased_quantity',
        'vat_product',
        'quick_note',
        'logistics_type',
        'stock_status',
        'is_hybrid_stock_enabled',
        'owner_id',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function productVariations(): HasMany
    {
        return $this->hasMany(ProductVariation::class, 'product_id');
    }
    public function images(): HasMany
    {
        return $this->hasMany(Image::class, 'product_id');
    }
    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class, 'product_id');
    }
}