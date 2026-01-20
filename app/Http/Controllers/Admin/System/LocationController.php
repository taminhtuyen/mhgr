<?php
namespace App\Http\Controllers\Admin\System;
use App\Services\System\LocationService;
use App\Http\Requests\Admin\System\LocationRequest;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class LocationController extends Controller {
    use HasTableSchema;
    public function index() {
        $tableName = 'provinces'; // Đại diện bảng Tỉnh/Thành
        return view('admin.system.locations.index', [
            'title' => 'Địa Chính'
        ]);
    }
}
