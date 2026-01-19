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
        $tableName = 'carts';

        return view('admin.schema-view', [
            'title' => 'Quản lý Giỏ hàng treo',
            'table' => $tableName,
            'columns' => $this->getSchema($tableName)
        ]);
    }
}
