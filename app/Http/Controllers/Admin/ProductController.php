<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class ProductController extends Controller {
    use HasTableSchema;
    public function index() {
        $tableName = 'products';
        return view('admin.schema-view', ['title' => 'Danh Sách Sản Phẩm', 'table' => $tableName, 'columns' => $this->getSchema($tableName)]);
    }
}
