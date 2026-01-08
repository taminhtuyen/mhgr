<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class PromotionController extends Controller {
    use HasTableSchema;
    public function index() {
        $tableName = 'promotions';
        return view('admin.schema-view', ['title' => 'Chiến Dịch Khuyến Mãi', 'table' => $tableName, 'columns' => $this->getSchema($tableName)]);
    }
}
