<?php
namespace App\Http\Controllers\Admin\System;
use App\Services\System\SystemLogService;
use App\Http\Requests\Admin\System\SystemLogRequest;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class SystemLogController extends Controller {
    use HasTableSchema;
    public function index() {
        // Bảng logs hệ thống
        return view('admin.system.system-logs.index', [
            'title' => 'Nhật Ký Hệ Thống'
        ]);
    }
}
