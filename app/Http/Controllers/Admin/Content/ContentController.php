<?php
namespace App\Http\Controllers\Admin\Content;
use App\Services\Content\ContentService;
use App\Http\Requests\Admin\Content\ContentRequest;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class ContentController extends Controller {
    use HasTableSchema;
    public function index() {
        return view('admin.content.contents.index', [
            'title' => 'Danh Sách Content'
        ]);
    }
}
