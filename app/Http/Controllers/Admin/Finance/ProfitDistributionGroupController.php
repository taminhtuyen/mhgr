<?php
namespace App\Http\Controllers\Admin\Finance;
use App\Services\Finance\ProfitDistributionGroupService;
use App\Http\Requests\Admin\Finance\ProfitDistributionGroupRequest;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class ProfitDistributionGroupController extends Controller {
    use HasTableSchema;
    public function index() {
        // Bảng chứa quy tắc chia tiền
        return view('admin.finance.profit-distribution-groups.index', [
            'title' => 'Cấu Hình Chia Lợi Nhuận'
        ]);
    }
}
