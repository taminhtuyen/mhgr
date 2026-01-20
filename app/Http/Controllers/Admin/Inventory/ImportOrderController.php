<?php
namespace App\Http\Controllers\Admin\Inventory;
use App\Services\Inventory\ImportOrderService;
use App\Http\Requests\Admin\Inventory\ImportOrderRequest;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class ImportOrderController extends Controller {
    use HasTableSchema;
    public function index() {
        return view('admin.inventory.import-orders.index', [
            'title' => 'Phiếu Nhập Hàng'
        ]);
    }
}
