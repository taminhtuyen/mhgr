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
        // Bảng 'contents' lưu trữ các trang tĩnh (Giới thiệu, Chính sách...)
        $schema = $this->getSchema('contents');

        return view('admin.schema-view', [
            'title' => 'Quản lý Trang tĩnh (Contents)',
            'schema' => $schema
        ]);
    }

    public function create()
    {
        return "Trang tạo trang tĩnh mới";
    }

    public function store(Request $request)
    {
        // Logic lưu
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        return "Trang chỉnh sửa trang tĩnh ID: " . $id;
    }

    public function update(Request $request, $id)
    {
        // Logic cập nhật
    }

    public function destroy($id)
    {
        // Logic xóa
    }
}
