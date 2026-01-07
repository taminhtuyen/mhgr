<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Image extends Model
{
    use HasFactory;

    protected $table = 'images';

    protected $fillable = [
        'url',
        'type',
        'alt_text',
        'caption',
        'filename_original',
        'size_kb',
        'status',
        'meta',
        'uploaded_by_user_id',
    ];

    /**
     * Quan hệ ngược Đa hình: Lấy ra tất cả Sản phẩm đang dùng ảnh này.
     */
    public function products(): MorphToMany
    {
        return $this->morphedByMany(Product::class, 'imageable', 'imageables', 'image_id', 'imageable_id');
    }

    /**
     * Quan hệ ngược Đa hình: Lấy ra tất cả Biến thể đang dùng ảnh này.
     */
    public function variations(): MorphToMany
    {
        return $this->morphedByMany(ProductVariation::class, 'imageable', 'imageables', 'image_id', 'imageable_id');
    }
}
