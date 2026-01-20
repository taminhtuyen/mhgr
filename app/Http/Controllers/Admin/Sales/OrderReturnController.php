<?php

namespace App\Http\Controllers\Admin\Sales;

use App\Http\Controllers\Controller;
use App\Services\Sales\OrderReturnService;
use App\Http\Requests\Admin\Sales\OrderReturnRequest;
use Illuminate\Http\Request;

class OrderReturnController extends Controller
{
    protected $service;

    public function __construct(OrderReturnService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('admin.sales.returns.index');
    }

    // Thêm các method khác nếu cần (store, update...)
}