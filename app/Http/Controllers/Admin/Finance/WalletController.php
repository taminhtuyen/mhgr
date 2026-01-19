<?php
namespace App\Http\Controllers\Admin\Finance;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class WalletController extends Controller {
    use HasTableSchema;
    public function index() {
        // Bảng ví tiền thành viên
        return view('admin.finance.wallets.index', [
            'title' => 'Quản Lý Ví Thành Viên'
        ]);
    }
}
