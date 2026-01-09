<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class PostController extends Controller {
    use HasTableSchema;
    public function index() {
        // Bảng tin tức
        $tableName = 'news';
        return view('admin.schema-view', ['title' => 'Quản Lý Tin Tức', 'table' => $tableName, 'columns' => $this->getSchema($tableName)]);
    }
}
