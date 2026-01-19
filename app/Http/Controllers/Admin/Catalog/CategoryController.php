<?php
namespace App\Http\Controllers\Admin\Catalog;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class CategoryController extends Controller {
    use HasTableSchema;
    public function index() {
        return view('admin.catalog.categorys.index', [
            'title' => 'Danh Mục Sản Phẩm'
        ]);
    }
}
