<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class UserController extends Controller {
    use HasTableSchema;
    public function index() {
        $tableName = 'users';
        return view('admin.schema-view', ['title' => 'Quản Lý Nhân Viên', 'table' => $tableName, 'columns' => $this->getSchema($tableName)]);
    }
}
