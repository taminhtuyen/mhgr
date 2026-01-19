<?php
namespace App\Http\Controllers\Admin\Inventory;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class WarehouseController extends Controller {
    use HasTableSchema;
    public function index() {
        return view('admin.inventory.warehouses.index', [
            'title' => 'Danh Sách Kho'
        ]);
    }
}
