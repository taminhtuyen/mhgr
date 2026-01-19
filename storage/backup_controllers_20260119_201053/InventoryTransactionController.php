<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class InventoryTransactionController extends Controller {
    use HasTableSchema;
    public function index() {
        // Bảng lịch sử xuất nhập tồn
        $tableName = 'inventory_transactions';
        return view('admin.schema-view', ['title' => 'Lịch Sử Biến Động Kho', 'table' => $tableName, 'columns' => $this->getSchema($tableName)]);
    }
}
