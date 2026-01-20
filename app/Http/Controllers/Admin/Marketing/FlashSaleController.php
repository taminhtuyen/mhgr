<?php
namespace App\Http\Controllers\Admin\Marketing;
use App\Services\Marketing\FlashSaleService;
use App\Http\Requests\Admin\Marketing\FlashSaleRequest;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class FlashSaleController extends Controller {
    use HasTableSchema;
    public function index() {
        return view('admin.marketing.flash-sales.index', [
            'title' => 'Flash Sale'
        ]);
    }
}
