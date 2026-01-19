<?php

namespace App\Http\Controllers\Admin\Sales;

use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class ReturnController extends Controller
{
    use HasTableSchema;

    public function index()
    {
        return view('admin.sales.returns.index', [
            'title' => 'Yêu Cầu Trả Hàng'
        ]);
    }
}
