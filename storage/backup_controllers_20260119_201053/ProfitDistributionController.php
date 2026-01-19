<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class ProfitDistributionController extends Controller {
    use HasTableSchema;
    public function index() {
        // Bảng chứa quy tắc chia tiền
        $tableName = 'profit_distribution_groups';
        return view('admin.schema-view', ['title' => 'Cấu Hình Chia Lợi Nhuận', 'table' => $tableName, 'columns' => $this->getSchema($tableName)]);
    }
}
