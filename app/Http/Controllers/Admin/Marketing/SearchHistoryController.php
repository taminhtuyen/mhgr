<?php
namespace App\Http\Controllers\Admin\Marketing;
use App\Services\Marketing\SearchHistoryService;
use App\Http\Requests\Admin\Marketing\SearchHistoryRequest;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class SearchHistoryController extends Controller {
    use HasTableSchema;
    public function index() {
        return view('admin.marketing.search-histories.index', [
            'title' => 'Danh Sách SearchHistory'
        ]);
    }
}
