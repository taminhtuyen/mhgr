<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;
use Illuminate\Http\Request;

class CategoryController extends Controller {
    use HasTableSchema;

    public function index() {
        return view('admin.catalog.categorys.index', [
            'title' => 'Quản lý Danh Mục Sản Phẩm'
        ]);
    }

    // Các method create, store, edit... sẽ được bổ sung hoặc xử lý qua Livewire Modal tùy vào workflow của bạn.
    // Hiện tại tập trung vào hiển thị Table.
}
