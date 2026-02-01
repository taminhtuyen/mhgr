<?php
namespace App\Http\Controllers\Admin\Finance;
use App\Services\Finance\RewardHistoryService;
use App\Http\Requests\Admin\Finance\RewardHistoryRequest;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class RewardHistoryController extends Controller {
    use HasTableSchema;
    public function index() {
        return view('admin.finance.reward-histories.index', [
            'title' => 'Danh Sách RewardHistory'
        ]);
    }
}
