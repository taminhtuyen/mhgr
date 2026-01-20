<?php

namespace App\Http\Controllers\Admin\Sales;
use App\Services\Sales\CartService;
use App\Http\Requests\Admin\Sales\CartRequest;

use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use HasTableSchema;

    public function index()
    {
        return view('admin.sales.carts.index', [
            'title' => 'Quản lý Giỏ hàng treo'
        ]);
    }
}
