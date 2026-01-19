<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class ReturnController extends Controller
{
    use HasTableSchema;

    public function index()
    {
        $tableName = 'order_returns';

        return view('admin.schema-view', [
            'title' => 'Yêu Cầu Trả Hàng',
            'table' => $tableName,
            'columns' => $this->getSchema($tableName)
        ]);
    }
}
