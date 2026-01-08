<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class LocationController extends Controller {
    use HasTableSchema;
    public function index() {
        $tableName = 'provinces'; // Đại diện bảng Tỉnh/Thành
        return view('admin.schema-view', ['title' => 'Địa Chính', 'table' => $tableName, 'columns' => $this->getSchema($tableName)]);
    }
}
