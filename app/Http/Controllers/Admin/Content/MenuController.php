<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    use HasTableSchema;

    public function index()
    {
        $tableName = 'menus'; // Tên bảng trong Database

        return view('admin.content.menus.index', [
            'title' => 'Quản lý Menu (Frontend)'
        ]);
    }
}
