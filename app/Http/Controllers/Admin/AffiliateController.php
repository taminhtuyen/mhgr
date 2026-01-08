<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class AffiliateController extends Controller {
    use HasTableSchema;
    public function index() {
        // Dùng bảng affiliate_links hoặc affiliate_commissions tùy bạn muốn xem gì trước
        $tableName = 'affiliate_links';
        return view('admin.schema-view', ['title' => 'Tiếp Thị Liên Kết', 'table' => $tableName, 'columns' => $this->getSchema($tableName)]);
    }
}
