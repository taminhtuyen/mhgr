<?php
namespace App\Http\Controllers\Admin\Consignment;
use App\Services\Consignment\ConsignmentCustomerService;
use App\Http\Requests\Admin\Consignment\ConsignmentCustomerRequest;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class ConsignmentCustomerController extends Controller {
    use HasTableSchema;
    public function index() {
        return view('admin.consignment.consignment-customers.index', [
            'title' => 'Khách Hàng Ký Gửi'
        ]);
    }
}
