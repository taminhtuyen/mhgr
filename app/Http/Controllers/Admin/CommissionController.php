<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class CommissionController extends Controller {
    use HasTableSchema;
    public function index() {
        // Bảng hoa hồng tiếp thị liên kết
        $tableName = 'affiliate_commissions';
        return view('admin.schema-view', ['title' => 'Lịch Sử Hoa Hồng', 'table' => $tableName, 'columns' => $this->getSchema($tableName)]);
    }
}
