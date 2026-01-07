<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';

    // Bảng này trong SQL của bạn cũng Partition, nhưng Laravel xử lý được.
    public $timestamps = false; // Bảng này trong SQL bạn để created_at là datetime default, không có updated_at

    protected $fillable = [
        'order_id',
        'product_id',
        'applied_promotion_rule_id',
        'product_variation_id',
        'product_name', // Lưu cứng tên SP lúc mua (phòng khi Admin đổi tên SP)
        'quantity',
        'price',        // Lưu cứng giá lúc mua (QUAN TRỌNG)
        'vat_rate',
        'total_price',
        'vat_amount',
        'logistics_type',
        'warehouse_id',
    ];

    /**
     * Quan hệ: Thuộc về đơn hàng nào.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Quan hệ: Link tới sản phẩm gốc (để xem ảnh, mô tả hiện tại).
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id')->withTrashed(); // withTrashed để vẫn xem được dù SP đã bị xóa mềm
    }

    public function variation(): BelongsTo
    {
        return $this->belongsTo(ProductVariation::class, 'product_variation_id');
    }
}
