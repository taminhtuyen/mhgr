<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrderItem extends Model
{
    use HasFactory;

    protected $table = 'purchase_order_items';

    protected $guarded = ['id']; // Cho phép điền mọi cột trừ ID (tiện lợi hơn $fillable khi chưa biết cột)

    // TODO: Định nghĩa quan hệ (Relationships) nếu cần thiết
}