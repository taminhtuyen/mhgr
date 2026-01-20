<?php
namespace App\Http\Controllers\Admin\Catalog;
use App\Services\Catalog\AttributeService;
use App\Http\Requests\Admin\Catalog\AttributeRequest;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class AttributeController extends Controller {
    use HasTableSchema;
    public function index() {
        return view('admin.catalog.attributes.index', [
            'title' => 'Thuộc Tính Sản Phẩm'
        ]);
    }
}
