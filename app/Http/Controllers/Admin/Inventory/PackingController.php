<?php
namespace App\Http\Controllers\Admin\Inventory;
use App\Services\Inventory\PackingService;
use App\Http\Requests\Admin\Inventory\PackingRequest;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class PackingController extends Controller {
    use HasTableSchema;
    public function index() {
        return view('admin.inventory.packings.index', [
            'title' => 'Danh Sách Packing'
        ]);
    }
}
