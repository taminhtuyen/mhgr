<?php
namespace App\Http\Controllers\Admin\Finance;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class CommissionController extends Controller {
    use HasTableSchema;
    public function index() {
        // Bảng hoa hồng tiếp thị liên kết
        return view('admin.finance.commissions.index', [
            'title' => 'Lịch Sử Hoa Hồng'
        ]);
    }
}
