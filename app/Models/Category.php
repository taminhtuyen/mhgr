<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'level',
        'path',
        'position',
        'is_active',
        'is_featured',
        'icon_url',
        'banner_url',
        'tax_class_id',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'fa_icon',
        'fa_icon_back',
        'logistics_mode',
    ];

    /**
     * Quan hệ: Danh mục cha (Đệ quy).
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Quan hệ: Các danh mục con.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Quan hệ: Một danh mục có nhiều sản phẩm.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
