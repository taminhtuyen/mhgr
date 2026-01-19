<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;
use Illuminate\Http\Request;

class PageController extends Controller
{
    use HasTableSchema;

    public function index()
    {
        return view('admin.content.pages.index', [
            'title' => 'Quản lý Trang tĩnh (Contents)'
        ]);
    }
}
