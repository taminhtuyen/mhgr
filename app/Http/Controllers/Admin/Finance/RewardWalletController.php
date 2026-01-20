<?php
namespace App\Http\Controllers\Admin\Finance;
use App\Services\Finance\RewardWalletService;
use App\Http\Requests\Admin\Finance\RewardWalletRequest;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class RewardWalletController extends Controller {
    use HasTableSchema;
    public function index() {
        // Bảng ví tiền thành viên
        return view('admin.finance.reward-wallets.index', [
            'title' => 'Quản Lý Ví Thành Viên'
        ]);
    }
}
