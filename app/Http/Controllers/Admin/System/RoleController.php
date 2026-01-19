<?php
namespace App\Http\Controllers\Admin\System;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class RoleController extends Controller {
    use HasTableSchema;
    public function index() {
        return view('admin.system.roles.index', [
            'title' => 'Phân Quyền & Vai Trò'
        ]);
    }
}
