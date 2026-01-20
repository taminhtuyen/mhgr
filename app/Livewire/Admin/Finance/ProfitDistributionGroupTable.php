<?php

namespace App\Livewire\Admin\Finance;

use Livewire\Component;
use Livewire\WithPagination;

class ProfitDistributionGroupTable extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.-finance.-profit-distribution-group-table');
    }
}
