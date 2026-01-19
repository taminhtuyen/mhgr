<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class ReviewController extends Controller {
    use HasTableSchema;
    public function index() {
        $tableName = 'product_reviews';
        return view('admin.schema-view', ['title' => 'Đánh Giá Sản Phẩm', 'table' => $tableName, 'columns' => $this->getSchema($tableName)]);
    }
}
