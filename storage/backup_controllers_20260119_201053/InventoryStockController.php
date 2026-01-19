<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class InventoryStockController extends Controller {
    use HasTableSchema;
    public function index() {
        $tableName = 'inventory_stocks';
        return view('admin.schema-view', ['title' => 'Tồn Kho Thực Tế', 'table' => $tableName, 'columns' => $this->getSchema($tableName)]);
    }
}
