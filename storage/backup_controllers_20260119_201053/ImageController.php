<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    use HasTableSchema;

    public function index()
    {
        $tableName = 'images';

        return view('admin.schema-view', [
            'title' => 'Thư viện hình ảnh (Media)',
            'table' => $tableName,
            'columns' => $this->getSchema($tableName)
        ]);
    }
}
