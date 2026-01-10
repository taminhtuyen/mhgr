<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use HasTableSchema;

    public function index()
    {
        // Bảng 'carts' lưu giỏ hàng của khách (bao gồm cả khách vãng lai)
        $schema = $this->getSchema('carts');

        return view('admin.schema-view', [
            'title' => 'Quản lý Giỏ hàng treo (Abandoned Carts)',
            'schema' => $schema
        ]);
    }

    public function show($id)
    {
        return "Xem chi tiết giỏ hàng ID: " . $id;
    }
}
