<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class SupplierController extends Controller {
    use HasTableSchema;
    public function index() {
        $tableName = 'suppliers';
        return view('admin.schema-view', ['title' => 'Nhà Cung Cấp', 'table' => $tableName, 'columns' => $this->getSchema($tableName)]);
    }
}
