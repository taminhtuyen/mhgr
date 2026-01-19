<?php
namespace App\Http\Controllers\Admin\System;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class UserController extends Controller {
    use HasTableSchema;
    public function index() {
        return view('admin.system.users.index', [
            'title' => 'Quản Lý Nhân Viên'
        ]);
    }
}
