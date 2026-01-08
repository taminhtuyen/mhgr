<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class CouponController extends Controller {
    use HasTableSchema;
    public function index() {
        $tableName = 'promotion_coupons';
        return view('admin.schema-view', ['title' => 'Mã Giảm Giá', 'table' => $tableName, 'columns' => $this->getSchema($tableName)]);
    }
}
