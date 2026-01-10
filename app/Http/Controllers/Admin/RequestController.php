<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    use HasTableSchema;

    public function index()
    {
        // Bảng 'requests' lưu góp ý từ khách hàng
        $schema = $this->getSchema('requests');

        return view('admin.schema-view', [
            'title' => 'Danh sách Yêu cầu & Góp ý',
            'schema' => $schema
        ]);
    }

    public function show($id)
    {
        return "Xem chi tiết yêu cầu ID: " . $id;
    }

    public function destroy($id)
    {
        // Logic xóa
    }
}
