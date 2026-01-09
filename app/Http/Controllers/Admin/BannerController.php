<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class BannerController extends Controller {
    use HasTableSchema;
    public function index() {
        // Bảng banner quảng cáo
        $tableName = 'banners';
        return view('admin.schema-view', ['title' => 'Quản Lý Banner', 'table' => $tableName, 'columns' => $this->getSchema($tableName)]);
    }
}
