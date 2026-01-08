<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class OrderController extends Controller
{
    use HasTableSchema;

    public function index()
    {
        // Tên bảng trong database của bạn
        $tableName = 'orders';

        return view('admin.schema-view', [
            'title' => 'Quản lý Đơn Hàng',
            'table' => $tableName,
            'columns' => $this->getSchema($tableName)
        ]);
    }
}
