<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class ProductTag extends Model
{
    use HasFactory;

    protected $table = 'product_tags';

    // Sử dụng guarded để an toàn cho các bảng giao dịch nhiều cột
    protected $guarded = ['id'];


    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class, 'tag_id');
    }
}