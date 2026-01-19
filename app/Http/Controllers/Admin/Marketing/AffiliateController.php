<?php
namespace App\Http\Controllers\Admin\Marketing;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class AffiliateController extends Controller {
    use HasTableSchema;
    public function index() {
        // Dùng bảng affiliate_links hoặc affiliate_commissions tùy bạn muốn xem gì trước
        return view('admin.marketing.affiliates.index', [
            'title' => 'Tiếp Thị Liên Kết'
        ]);
    }
}
