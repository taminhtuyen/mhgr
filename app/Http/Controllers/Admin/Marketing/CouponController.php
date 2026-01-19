<?php
namespace App\Http\Controllers\Admin\Marketing;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class CouponController extends Controller {
    use HasTableSchema;
    public function index() {
        return view('admin.marketing.coupons.index', [
            'title' => 'Mã Giảm Giá'
        ]);
    }
}
