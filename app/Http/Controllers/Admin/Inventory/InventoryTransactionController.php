<?php
namespace App\Http\Controllers\Admin\Inventory;
use App\Services\Inventory\InventoryTransactionService;
use App\Http\Requests\Admin\Inventory\InventoryTransactionRequest;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class InventoryTransactionController extends Controller {
    use HasTableSchema;
    public function index() {
        // Bảng lịch sử xuất nhập tồn
        return view('admin.inventory.inventory-transactions.index', [
            'title' => 'Lịch Sử Biến Động Kho'
        ]);
    }
}
