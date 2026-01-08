<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class PurchaseOrderController extends Controller {
    use HasTableSchema;
    public function index() {
        $tableName = 'purchase_orders';
        return view('admin.schema-view', ['title' => 'Phiếu Nhập Hàng', 'table' => $tableName, 'columns' => $this->getSchema($tableName)]);
    }
}
