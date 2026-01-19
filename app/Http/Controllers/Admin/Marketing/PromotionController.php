<?php
namespace App\Http\Controllers\Admin\Marketing;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class PromotionController extends Controller {
    use HasTableSchema;
    public function index() {
        return view('admin.marketing.promotions.index', [
            'title' => 'Chiến Dịch Khuyến Mãi'
        ]);
    }
}
