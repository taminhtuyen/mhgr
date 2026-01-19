<?php
namespace App\Http\Controllers\Admin\Marketing;
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
