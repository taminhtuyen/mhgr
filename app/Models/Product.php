<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'status', // A: Active, I: Inactive...
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

    /**
     * Quan hệ: Thuộc về một danh mục.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Quan hệ: Có nhiều biến thể (Màu sắc, kích thước...).
     */
    public function variations(): HasMany
    {
        return $this->hasMany(ProductVariation::class, 'product_id');
    }

    /**
     * Quan hệ Đa hình: Sản phẩm có nhiều hình ảnh.
     * Bảng trung gian: imageables
     */
    public function images(): MorphToMany
    {
        return $this->morphToMany(Image::class, 'imageable', 'imageables', 'imageable_id', 'image_id')
            ->withPivot('position', 'meta');
    }

    /**
     * Quan hệ: Tồn kho thực tế trong các kho hàng.
     */
    public function inventoryStocks(): HasMany
    {
        return $this->hasMany(InventoryStock::class, 'product_id');
    }
}
