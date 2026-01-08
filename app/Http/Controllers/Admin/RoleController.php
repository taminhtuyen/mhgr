<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class RoleController extends Controller {
    use HasTableSchema;
    public function index() {
        $tableName = 'roles';
        return view('admin.schema-view', ['title' => 'Phân Quyền & Vai Trò', 'table' => $tableName, 'columns' => $this->getSchema($tableName)]);
    }
}
