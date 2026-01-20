<?php
namespace App\Http\Controllers\Admin\Catalog;
use App\Services\Catalog\CategoryService;
use App\Http\Requests\Admin\Catalog\CategoryRequest;
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
