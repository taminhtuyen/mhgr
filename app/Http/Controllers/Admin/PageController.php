<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;
use Illuminate\Http\Request;

class PageController extends Controller
{
    use HasTableSchema;

    public function index()
    {
        $tableName = 'contents';

        return view('admin.schema-view', [
            'title' => 'Quản lý Trang tĩnh (Contents)',
            'table' => $tableName,
            'columns' => $this->getSchema($tableName)
        ]);
    }
}
