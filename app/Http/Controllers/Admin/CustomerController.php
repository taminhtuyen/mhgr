<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class CustomerController extends Controller {
    use HasTableSchema;
    public function index() {
        $tableName = 'users'; // Hoặc users_customer_profiles nếu bạn muốn xem chi tiết hồ sơ
        return view('admin.schema-view', ['title' => 'Khách Hàng', 'table' => $tableName, 'columns' => $this->getSchema($tableName)]);
    }
}
