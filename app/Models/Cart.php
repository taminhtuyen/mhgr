<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';

    protected $fillable = [
        'user_id',
        'session_id', // Quan trọng cho khách vãng lai
        'status',     // 1: Active, 2: Converted (Đã đặt đơn)
        'coupon_code',
        'total_price',
        'currency',
        'ip_address',
        'user_agent',
        'metadata',
        'total_quantity',
    ];

    /**
     * Quan hệ: Một giỏ hàng có nhiều sản phẩm bên trong.
     */
    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class, 'cart_id');
    }

    /**
     * Quan hệ: Giỏ hàng thuộc về người dùng nào (nếu đã đăng nhập).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
