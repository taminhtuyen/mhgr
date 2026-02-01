<?php
namespace App\Http\Controllers\Admin\Logistics;
use App\Services\Logistics\DeliveryFailureService;
use App\Http\Requests\Admin\Logistics\DeliveryFailureRequest;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class DeliveryFailureController extends Controller {
    use HasTableSchema;
    public function index() {
        return view('admin.logistics.delivery-failures.index', [
            'title' => 'Danh Sách DeliveryFailure'
        ]);
    }
}
