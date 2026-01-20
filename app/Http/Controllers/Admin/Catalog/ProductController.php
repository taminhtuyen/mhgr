<?php
namespace App\Http\Controllers\Admin\Catalog;
use App\Services\Catalog\ProductService;
use App\Http\Requests\Admin\Catalog\ProductRequest;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class ProductController extends Controller {
    use HasTableSchema;
    public function index() {
        return view('admin.catalog.products.index', [
            'title' => 'Danh Sách Sản Phẩm'
        ]);
    }
}
