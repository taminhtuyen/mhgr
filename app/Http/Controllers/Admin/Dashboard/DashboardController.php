<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\DashboardService;
use App\Http\Requests\Admin\Dashboard\DashboardRequest;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $service;

    /**
     * Inject Service vào Controller
     */
    public function __construct(DashboardService $service)
    {
        $this->service = $service;
    }

    /**
     * Hiển thị trang Dashboard
     * Sử dụng DashboardRequest để validate nếu sau này có filter ngày tháng
     */
    public function index(DashboardRequest $request)
    {
        // Sau này bạn có thể gọi: $stats = $this->service->getStatistics($request->validated());

        return view('admin.dashboard.dashboards.index', [
            'title' => 'Tổng Quan Hệ Thống'
        ]);
    }
}
