<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Services\System\BookingStatusService;
use App\Http\Requests\Admin\System\BookingStatusRequest;
use App\Models\BookingStatus;
use Illuminate\Http\Request;

class BookingStatusController extends Controller
{
    protected $bookingStatusService;

    public function __construct(BookingStatusService $service)
    {
        $this->bookingStatusService = $service;
    }

    public function index()
    {
        return view('admin.system.booking-statuses.index', [
            'title' => 'Quản lý BookingStatus'
        ]);
    }

    public function store(BookingStatusRequest $request)
    {
        $result = $this->bookingStatusService->create($request->validated());
        if($result) return redirect()->route('admin.system.booking-statuses.index')->with('success', 'Thêm mới thành công!');
        return back()->with('error', 'Lỗi khi thêm mới.');
    }

    public function update(BookingStatusRequest $request, BookingStatus $bookingStatus)
    {
        $result = $this->bookingStatusService->update($bookingStatus, $request->validated());
        if($result) return redirect()->route('admin.system.booking-statuses.index')->with('success', 'Cập nhật thành công!');
        return back()->with('error', 'Lỗi khi cập nhật.');
    }

    public function destroy(BookingStatus $bookingStatus)
    {
        $this->bookingStatusService->delete($bookingStatus);
        return redirect()->back()->with('success', 'Đã xóa dữ liệu.');
    }
}