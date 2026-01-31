<?php

namespace App\Http\Controllers\Admin\Logistics;

use App\Http\Controllers\Controller;
use App\Services\Logistics\DeliveryTripService;
use App\Http\Requests\Admin\Logistics\DeliveryTripRequest;
use App\Models\DeliveryTrip;
use Illuminate\Http\Request;

class DeliveryTripController extends Controller
{
    protected $deliveryTripService;

    public function __construct(DeliveryTripService $service)
    {
        $this->deliveryTripService = $service;
    }

    public function index()
    {
        return view('admin.logistics.delivery-trips.index', [
            'title' => 'Quản lý DeliveryTrip'
        ]);
    }

    public function store(DeliveryTripRequest $request)
    {
        $result = $this->deliveryTripService->create($request->validated());
        if($result) return redirect()->route('admin.logistics.delivery-trips.index')->with('success', 'Thêm mới thành công!');
        return back()->with('error', 'Lỗi khi thêm mới.');
    }

    public function update(DeliveryTripRequest $request, DeliveryTrip $deliveryTrip)
    {
        $result = $this->deliveryTripService->update($deliveryTrip, $request->validated());
        if($result) return redirect()->route('admin.logistics.delivery-trips.index')->with('success', 'Cập nhật thành công!');
        return back()->with('error', 'Lỗi khi cập nhật.');
    }

    public function destroy(DeliveryTrip $deliveryTrip)
    {
        $this->deliveryTripService->delete($deliveryTrip);
        return redirect()->back()->with('success', 'Đã xóa dữ liệu.');
    }
}