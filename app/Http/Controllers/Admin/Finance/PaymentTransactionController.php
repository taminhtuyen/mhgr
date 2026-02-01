<?php
namespace App\Http\Controllers\Admin\Finance;
use App\Services\Finance\PaymentTransactionService;
use App\Http\Requests\Admin\Finance\PaymentTransactionRequest;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class PaymentTransactionController extends Controller {
    use HasTableSchema;
    public function index() {
        return view('admin.finance.payment-transactions.index', [
            'title' => 'Danh Sách PaymentTransaction'
        ]);
    }
}
