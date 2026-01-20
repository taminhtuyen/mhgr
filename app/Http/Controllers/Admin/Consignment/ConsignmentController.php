<?php
namespace App\Http\Controllers\Admin\Consignment;
use App\Services\Consignment\ConsignmentService;
use App\Http\Requests\Admin\Consignment\ConsignmentRequest;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class ConsignmentController extends Controller {
    use HasTableSchema;
    public function index() {
        return view('admin.consignment.consignments.index', [
            'title' => 'Phiếu Ký Gửi'
        ]);
    }
}
