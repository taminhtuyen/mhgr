<?php
namespace App\Http\Controllers\Admin\Finance;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class ProfitDistributionController extends Controller {
    use HasTableSchema;
    public function index() {
        // Bảng chứa quy tắc chia tiền
        return view('admin.finance.profit-distributions.index', [
            'title' => 'Cấu Hình Chia Lợi Nhuận'
        ]);
    }
}
