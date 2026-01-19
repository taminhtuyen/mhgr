<?php
namespace App\Http\Controllers\Admin\Catalog;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class ReviewController extends Controller {
    use HasTableSchema;
    public function index() {
        return view('admin.catalog.reviews.index', [
            'title' => 'Đánh Giá Sản Phẩm'
        ]);
    }
}
