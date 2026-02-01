<?php
namespace App\Http\Controllers\Admin\Catalog;
use App\Services\Catalog\CategoryCollectionService;
use App\Http\Requests\Admin\Catalog\CategoryCollectionRequest;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class CategoryCollectionController extends Controller {
    use HasTableSchema;
    public function index() {
        return view('admin.catalog.category-collections.index', [
            'title' => 'Danh Sách CategoryCollection'
        ]);
    }
}
