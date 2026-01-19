<?php
namespace App\Http\Controllers\Admin\CRM;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class CustomerController extends Controller {
    use HasTableSchema;
    public function index() {
        $tableName = 'users'; // Hoặc users_customer_profiles nếu bạn muốn xem chi tiết hồ sơ
        return view('admin.crm.customers.index', [
            'title' => 'Khách Hàng'
        ]);
    }
}
