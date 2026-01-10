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
        // Bảng 'images' quản lý toàn bộ file ảnh đã upload lên hệ thống
        $schema = $this->getSchema('images');

        return view('admin.schema-view', [
            'title' => 'Thư viện hình ảnh (Media)',
            'schema' => $schema
        ]);
    }

    public function create()
    {
        return "Trang upload ảnh mới";
    }

    public function store(Request $request)
    {
        // Logic upload
    }

    public function destroy($id)
    {
        // Logic xóa ảnh
    }
}
