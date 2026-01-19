<?php
namespace App\Http\Controllers\Admin\System;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class SettingController extends Controller {
    use HasTableSchema;
    public function index() {
        return view('admin.system.settings.index', [
            'title' => 'Cài Đặt Hệ Thống'
        ]);
    }
}
