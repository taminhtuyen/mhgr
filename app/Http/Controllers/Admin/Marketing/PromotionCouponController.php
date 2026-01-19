<?php
namespace App\Http\Controllers\Admin\Marketing;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class PromotionCouponController extends Controller {
    use HasTableSchema;
    public function index() {
        return view('admin.marketing.promotion-coupons.index', [
            'title' => 'Mã Giảm Giá'
        ]);
    }
}
