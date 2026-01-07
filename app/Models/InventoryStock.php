<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryStock extends Model
{
    use HasFactory;

    protected $table = 'inventory_stocks';

    protected $fillable = [
        'warehouse_id',
        'product_id',
        'product_variation_id',
        'quantity',         // Số lượng thực tế
        'reserved_quantity', // Số lượng đang giữ cho đơn chưa ship
        'shelf_location',    // Vị trí kệ hàng
    ];

    /**
     * Quan hệ: Thuộc về sản phẩm nào.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Quan hệ: Thuộc về biến thể nào (nếu có).
     */
    public function variation(): BelongsTo
    {
        return $this->belongsTo(ProductVariation::class, 'product_variation_id');
    }

    // Nếu bạn muốn tạo thêm Model InventoryWarehouse thì uncomment dòng dưới
    // public function warehouse(): BelongsTo
    // {
    //     return $this->belongsTo(InventoryWarehouse::class, 'warehouse_id');
    // }
}
