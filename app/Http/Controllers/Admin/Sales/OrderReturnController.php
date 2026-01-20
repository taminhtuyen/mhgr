<?php

namespace App\Http\Controllers\Admin\Sales;
use App\Services\Sales\OrderReturnService;

use App\Http\Controllers\Controller;
use App\Services\Sales\OrderOrderReturnService;
use App\Http\Requests\Admin\Sales\OrderReturnRequest;
use Illuminate\Http\Request;

class OrderReturnController extends Controller
{
    protected $service;

    public function __construct(OrderOrderReturnService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        // TODO: Implement logic
        return view('admin.sales.returns.index');
    }
}