<?php
namespace App\Http\Controllers\Admin\Content;
use App\Services\Content\NewsService;
use App\Http\Requests\Admin\Content\NewsRequest;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class NewsController extends Controller {
    use HasTableSchema;
    public function index() {
        return view('admin.content.news.index', [
            'title' => 'Danh Sách News'
        ]);
    }
}
