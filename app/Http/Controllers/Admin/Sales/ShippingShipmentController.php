<?php

namespace App\Http\Controllers\Admin\Sales;

use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class ShippingShipmentController extends Controller
{
    use HasTableSchema;

    public function index()
    {
        // Chọn bảng chuyến giao hàng để hiển thị chính
        return view('admin.sales.deliverys.index', [
            'title' => 'Quản lý Vận Chuyển'
        ]);
    }
}
