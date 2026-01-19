<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'order_code',
        'buyer_id',
        'buyer_type',
        'seller_id',
        'seller_type',
        'shipping_manager_id',
        'preparing_manager_id',
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
        'profit_user',
        'profit_admin',
        'vat_user',
        'vat_admin',
        'payment_method',
        'payment_status',
        'level_customer',
        'customer_group',
        'status',
        'is_packing',
        'delivery_trip_id',
        'note',
        'invoice_requested',
        'order_type',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
    public function delivery(): HasOne
    {
        return $this->hasOne(ShippingShipment::class, 'order_id');
    }
    public function orderReturns(): HasMany
    {
        return $this->hasMany(OrderReturn::class, 'order_id');
    }
}