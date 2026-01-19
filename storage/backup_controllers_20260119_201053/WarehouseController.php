<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class WarehouseController extends Controller {
    use HasTableSchema;
    public function index() {
        $tableName = 'inventory_warehouses';
        return view('admin.schema-view', ['title' => 'Danh Sách Kho', 'table' => $tableName, 'columns' => $this->getSchema($tableName)]);
    }
}
