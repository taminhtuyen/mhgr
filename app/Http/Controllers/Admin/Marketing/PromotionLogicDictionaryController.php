<?php
namespace App\Http\Controllers\Admin\Marketing;
use App\Services\Marketing\PromotionLogicDictionaryService;
use App\Http\Requests\Admin\Marketing\PromotionLogicDictionaryRequest;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class PromotionLogicDictionaryController extends Controller {
    use HasTableSchema;
    public function index() {
        return view('admin.marketing.promotion-logic-dictionaries.index', [
            'title' => 'Danh Sách PromotionLogicDictionary'
        ]);
    }
}
