<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    use HasTableSchema;

    public function index()
    {
        $tableName = 'menus'; // Tên bảng trong Database

        return view('admin.schema-view', [
            'title' => 'Quản lý Menu (Frontend)',
            'table' => $tableName,
            'columns' => $this->getSchema($tableName)
        ]);
    }
}
