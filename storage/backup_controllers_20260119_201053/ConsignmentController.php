<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class ConsignmentController extends Controller {
    use HasTableSchema;
    public function index() {
        $tableName = 'consignment_orders';
        return view('admin.schema-view', ['title' => 'Phiếu Ký Gửi', 'table' => $tableName, 'columns' => $this->getSchema($tableName)]);
    }
}
