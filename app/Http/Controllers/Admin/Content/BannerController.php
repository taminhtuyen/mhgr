<?php
namespace App\Http\Controllers\Admin\Content;
use App\Services\Content\BannerService;
use App\Http\Requests\Admin\Content\BannerRequest;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class BannerController extends Controller {
    use HasTableSchema;
    public function index() {
        // Bảng banner quảng cáo
        return view('admin.content.banners.index', [
            'title' => 'Quản Lý Banner'
        ]);
    }
}
