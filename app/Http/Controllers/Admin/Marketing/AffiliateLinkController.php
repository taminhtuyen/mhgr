<?php
namespace App\Http\Controllers\Admin\Marketing;
use App\Services\Marketing\AffiliateLinkService;
use App\Http\Requests\Admin\Marketing\AffiliateLinkRequest;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class AffiliateLinkController extends Controller {
    use HasTableSchema;
    public function index() {
        // Dùng bảng affiliate_links hoặc affiliate_commissions tùy bạn muốn xem gì trước
        return view('admin.marketing.affiliate-links.index', [
            'title' => 'Tiếp Thị Liên Kết'
        ]);
    }
}
