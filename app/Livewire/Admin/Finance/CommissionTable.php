<?php

namespace App\Livewire\Admin\Finance;

use Livewire\Component;
use Livewire\WithPagination;

class CommissionTable extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.-finance.-commission-table');
    }
}
