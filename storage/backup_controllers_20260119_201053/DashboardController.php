<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Tạm thời hiển thị trang chào mừng, sau này sẽ thay bằng biểu đồ thống kê
        return view('admin.schema-view', [
            'title' => 'Tổng Quan Hệ Thống (Dashboard)',
            'table' => 'users', // Tạm thời load bảng users để demo giao diện không bị lỗi
            'columns' => [] // Không load cột nào cả
        ]);
    }
}
