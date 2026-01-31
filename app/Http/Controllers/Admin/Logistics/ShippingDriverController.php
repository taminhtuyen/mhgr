<?php

namespace App\Http\Controllers\Admin\Logistics;

use App\Http\Controllers\Controller;
use App\Services\Logistics\ShippingDriverService;
use App\Http\Requests\Admin\Logistics\ShippingDriverRequest;
use App\Models\ShippingDriver;
use Illuminate\Http\Request;

class ShippingDriverController extends Controller
{
    protected $shippingDriverService;

    public function __construct(ShippingDriverService $service)
    {
        $this->shippingDriverService = $service;
    }

    public function index()
    {
        return view('admin.logistics.shipping-drivers.index', [
            'title' => 'Quản lý ShippingDriver'
        ]);
    }

    public function store(ShippingDriverRequest $request)
    {
        $result = $this->shippingDriverService->create($request->validated());
        if($result) return redirect()->route('admin.logistics.shipping-drivers.index')->with('success', 'Thêm mới thành công!');
        return back()->with('error', 'Lỗi khi thêm mới.');
    }

    public function update(ShippingDriverRequest $request, ShippingDriver $shippingDriver)
    {
        $result = $this->shippingDriverService->update($shippingDriver, $request->validated());
        if($result) return redirect()->route('admin.logistics.shipping-drivers.index')->with('success', 'Cập nhật thành công!');
        return back()->with('error', 'Lỗi khi cập nhật.');
    }

    public function destroy(ShippingDriver $shippingDriver)
    {
        $this->shippingDriverService->delete($shippingDriver);
        return redirect()->back()->with('success', 'Đã xóa dữ liệu.');
    }
}