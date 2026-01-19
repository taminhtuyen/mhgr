<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class SettingController extends Controller {
    use HasTableSchema;
    public function index() {
        $tableName = 'settings';
        return view('admin.schema-view', ['title' => 'Cài Đặt Hệ Thống', 'table' => $tableName, 'columns' => $this->getSchema($tableName)]);
    }
}
