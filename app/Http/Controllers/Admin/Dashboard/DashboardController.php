<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Cập nhật đường dẫn view theo cấu trúc mới:
        // resources/views/admin/dashboard/dashboards/index.blade.php
        return view('admin.dashboard.dashboards.index', [
            'title' => 'Tổng Quan Hệ Thống'
        ]);
    }
}
