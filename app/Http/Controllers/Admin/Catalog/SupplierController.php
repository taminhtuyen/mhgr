<?php
namespace App\Http\Controllers\Admin\Catalog;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class SupplierController extends Controller {
    use HasTableSchema;
    public function index() {
        return view('admin.catalog.suppliers.index', [
            'title' => 'Nhà Cung Cấp'
        ]);
    }
}
