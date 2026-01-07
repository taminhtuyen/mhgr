<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'order_code',
        'customer_id',
        'shipping_manager_id', // Shipper
        'preparing_manager_id', // Người nhặt hàng
        'shipping_name',
        'shipping_phone',
        'shipping_address',
        'shipping_province_id',
        'shipping_ward_id',
        'shipping_lat',
        'shipping_lng',
        'total_product_price',
        'total_shipping_fee',
        'total_discount',
        'total_tax_amount',
        'vat_percentage',
        'final_amount',
        'shipping_method_id',
        'payment_method',
        'payment_status', // unpaid, paid...
        'status',         // pending, shipping, completed...
        'is_packing',
        'note',
        'invoice_requested',
        'seller_id',
        'order_type',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'is_packing' => 'boolean',
            'invoice_requested' => 'boolean',
        ];
    }

    /**
     * Quan hệ: Đơn hàng gồm những món gì (Chi tiết đơn).
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    /**
     * Quan hệ: Lịch sử xử lý đơn hàng (Ai duyệt, ai giao...).
     */
    public function history(): HasMany
    {
        return $this->hasMany(OrderHistory::class, 'order_id');
    }

    /**
     * Quan hệ: Khách hàng mua đơn này.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
