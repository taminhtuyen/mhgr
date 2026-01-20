<?php

namespace App\Http\Controllers\Admin\Sales;
use App\Services\Sales\OrderService;
use App\Http\Requests\Admin\Sales\OrderRequest;

use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class OrderController extends Controller
{
    use HasTableSchema;

    public function index()
    {
        // Tên bảng trong database của bạn
        return view('admin.sales.orders.index', [
            'title' => 'Quản lý Đơn Hàng'
        ]);
    }
}
