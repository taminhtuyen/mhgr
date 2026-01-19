<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class ConsignmentCustomerController extends Controller {
    use HasTableSchema;
    public function index() {
        $tableName = 'consignment_customers';
        return view('admin.schema-view', ['title' => 'Khách Hàng Ký Gửi', 'table' => $tableName, 'columns' => $this->getSchema($tableName)]);
    }
}
