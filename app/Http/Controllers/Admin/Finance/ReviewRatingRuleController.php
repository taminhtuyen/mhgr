<?php
namespace App\Http\Controllers\Admin\Finance;
use App\Services\Finance\ReviewRatingRuleService;
use App\Http\Requests\Admin\Finance\ReviewRatingRuleRequest;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class ReviewRatingRuleController extends Controller {
    use HasTableSchema;
    public function index() {
        return view('admin.finance.review-rating-rules.index', [
            'title' => 'Danh Sách ReviewRatingRule'
        ]);
    }
}
