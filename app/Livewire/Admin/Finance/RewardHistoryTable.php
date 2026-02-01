<?php

namespace App\Livewire\Admin\Finance;

use Livewire\Component;
use Livewire\WithPagination;

class RewardHistoryTable extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.finance.reward-history-table');
    }
}
