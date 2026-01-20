<?php
namespace App\Http\Controllers\Admin\Content;
use App\Services\Content\PostService;
use App\Http\Requests\Admin\Content\PostRequest;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class PostController extends Controller {
    use HasTableSchema;
    public function index() {
        // Bảng tin tức
        return view('admin.content.posts.index', [
            'title' => 'Quản Lý Tin Tức'
        ]);
    }
}
