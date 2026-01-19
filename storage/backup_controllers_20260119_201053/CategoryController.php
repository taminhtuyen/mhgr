<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class CategoryController extends Controller {
    use HasTableSchema;
    public function index() {
        $tableName = 'categories';
        return view('admin.schema-view', ['title' => 'Danh Mục Sản Phẩm', 'table' => $tableName, 'columns' => $this->getSchema($tableName)]);
    }
}
