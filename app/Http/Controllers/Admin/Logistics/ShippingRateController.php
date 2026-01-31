<?php

namespace App\Http\Controllers\Admin\Logistics;

use App\Http\Controllers\Controller;
use App\Services\Logistics\ShippingRateService;
use App\Http\Requests\Admin\Logistics\ShippingRateRequest;
use App\Models\ShippingRate;
use Illuminate\Http\Request;

class ShippingRateController extends Controller
{
    protected $shippingRateService;

    public function __construct(ShippingRateService $service)
    {
        $this->shippingRateService = $service;
    }

    public function index()
    {
        return view('admin.logistics.shipping-rates.index', [
            'title' => 'Quản lý ShippingRate'
        ]);
    }

    public function store(ShippingRateRequest $request)
    {
        $result = $this->shippingRateService->create($request->validated());
        if($result) return redirect()->route('admin.logistics.shipping-rates.index')->with('success', 'Thêm mới thành công!');
        return back()->with('error', 'Lỗi khi thêm mới.');
    }

    public function update(ShippingRateRequest $request, ShippingRate $shippingRate)
    {
        $result = $this->shippingRateService->update($shippingRate, $request->validated());
        if($result) return redirect()->route('admin.logistics.shipping-rates.index')->with('success', 'Cập nhật thành công!');
        return back()->with('error', 'Lỗi khi cập nhật.');
    }

    public function destroy(ShippingRate $shippingRate)
    {
        $this->shippingRateService->delete($shippingRate);
        return redirect()->back()->with('success', 'Đã xóa dữ liệu.');
    }
}