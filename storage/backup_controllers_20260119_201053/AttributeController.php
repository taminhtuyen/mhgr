<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class AttributeController extends Controller {
    use HasTableSchema;
    public function index() {
        $tableName = 'product_attributes';
        return view('admin.schema-view', ['title' => 'Thuộc Tính Sản Phẩm', 'table' => $tableName, 'columns' => $this->getSchema($tableName)]);
    }
}
