<?php
namespace App\Http\Controllers\Admin\Catalog;
use App\Services\Catalog\ProductReviewService;
use App\Http\Requests\Admin\Catalog\ProductReviewRequest;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class ProductReviewController extends Controller {
    use HasTableSchema;
    public function index() {
        return view('admin.catalog.product-reviews.index', [
            'title' => 'Đánh Giá Sản Phẩm'
        ]);
    }
}
