<?php
namespace App\Http\Controllers\Admin\Inventory;
use App\Services\Inventory\InventoryStockService;
use App\Http\Requests\Admin\Inventory\InventoryStockRequest;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class InventoryStockController extends Controller {
    use HasTableSchema;
    public function index() {
        return view('admin.inventory.inventory-stocks.index', [
            'title' => 'Tồn Kho Thực Tế'
        ]);
    }
}
