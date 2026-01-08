<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class DeliveryController extends Controller
{
    use HasTableSchema;

    public function index()
    {
        // Chọn bảng chuyến giao hàng để hiển thị chính
        $tableName = 'delivery_trips';

        return view('admin.schema-view', [
            'title' => 'Quản lý Vận Chuyển',
            'table' => $tableName,
            'columns' => $this->getSchema($tableName)
        ]);
    }
}
