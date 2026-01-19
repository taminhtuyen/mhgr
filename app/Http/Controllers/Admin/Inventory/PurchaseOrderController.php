<?php
namespace App\Http\Controllers\Admin\Inventory;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class PurchaseOrderController extends Controller {
    use HasTableSchema;
    public function index() {
        return view('admin.inventory.purchase-orders.index', [
            'title' => 'Phiếu Nhập Hàng'
        ]);
    }
}
