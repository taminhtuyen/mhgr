<?php

namespace App\Livewire\Admin\Finance;

use Livewire\Component;
use Livewire\WithPagination;

class ReviewRatingRuleTable extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.finance.review-rating-rule-table');
    }
}
