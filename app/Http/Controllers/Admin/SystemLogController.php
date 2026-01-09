<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class SystemLogController extends Controller {
    use HasTableSchema;
    public function index() {
        // Bảng logs hệ thống
        $tableName = 'system_logs';
        return view('admin.schema-view', ['title' => 'Nhật Ký Hệ Thống', 'table' => $tableName, 'columns' => $this->getSchema($tableName)]);
    }
}
