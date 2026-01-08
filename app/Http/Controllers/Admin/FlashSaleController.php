<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class FlashSaleController extends Controller {
    use HasTableSchema;
    public function index() {
        $tableName = 'flash_sales';
        return view('admin.schema-view', ['title' => 'Flash Sale', 'table' => $tableName, 'columns' => $this->getSchema($tableName)]);
    }
}
