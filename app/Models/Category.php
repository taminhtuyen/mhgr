<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

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
        'fa_icon',         // Icon chính
        'fa_icon_back',    // Icon phụ
        'tax_class_id',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'logistics_mode'
    ];

    /**
     * Relationship: Lấy danh mục cha
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Relationship: Lấy các danh mục con trực tiếp
     * (Đây là hàm mà bạn đang thiếu gây ra lỗi)
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Relationship Helper: Lấy toàn bộ cây con cháu (Đệ quy)
     * Dùng khi muốn load sâu nhiều cấp: Category::with('childrenRecursive')->get();
     */
    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    /**
     * Relationship: Sản phẩm thuộc danh mục này
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
