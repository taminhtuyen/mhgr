<?php
namespace App\Http\Controllers\Admin\Finance;
use App\Services\Finance\CommissionService;
use App\Http\Requests\Admin\Finance\CommissionRequest;
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
