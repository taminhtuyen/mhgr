<?php

namespace App\Http\Controllers\Admin\Logistics;

use App\Http\Controllers\Controller;
use App\Services\Logistics\ShippingPartnerService;
use App\Http\Requests\Admin\Logistics\ShippingPartnerRequest;
use App\Models\ShippingPartner;
use Illuminate\Http\Request;

class ShippingPartnerController extends Controller
{
    protected $shippingPartnerService;

    public function __construct(ShippingPartnerService $service)
    {
        $this->shippingPartnerService = $service;
    }

    public function index()
    {
        return view('admin.logistics.shipping-partners.index', [
            'title' => 'Quản lý ShippingPartner'
        ]);
    }

    public function store(ShippingPartnerRequest $request)
    {
        $result = $this->shippingPartnerService->create($request->validated());
        if($result) return redirect()->route('admin.logistics.shipping-partners.index')->with('success', 'Thêm mới thành công!');
        return back()->with('error', 'Lỗi khi thêm mới.');
    }

    public function update(ShippingPartnerRequest $request, ShippingPartner $shippingPartner)
    {
        $result = $this->shippingPartnerService->update($shippingPartner, $request->validated());
        if($result) return redirect()->route('admin.logistics.shipping-partners.index')->with('success', 'Cập nhật thành công!');
        return back()->with('error', 'Lỗi khi cập nhật.');
    }

    public function destroy(ShippingPartner $shippingPartner)
    {
        $this->shippingPartnerService->delete($shippingPartner);
        return redirect()->back()->with('success', 'Đã xóa dữ liệu.');
    }
}