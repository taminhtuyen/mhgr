<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class WalletController extends Controller {
    use HasTableSchema;
    public function index() {
        // Bảng ví tiền thành viên
        $tableName = 'users_reward_wallets';
        return view('admin.schema-view', ['title' => 'Quản Lý Ví Thành Viên', 'table' => $tableName, 'columns' => $this->getSchema($tableName)]);
    }
}
