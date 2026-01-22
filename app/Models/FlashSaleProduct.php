<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class FlashSaleProduct extends Model
{
    use HasFactory;

    protected $table = 'flash_sale_items';

    // Sử dụng guarded để an toàn cho các bảng giao dịch nhiều cột
    protected $guarded = ['id'];


    public function flashSale(): BelongsTo
    {
        return $this->belongsTo(FlashSale::class, 'flash_sale_id');
    }
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
