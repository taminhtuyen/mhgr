<?php

namespace App\Livewire\Admin\Dashboard;

use Livewire\Component;
use Livewire\WithPagination;

class DashboardTable extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.-dashboard.-dashboard-table');
    }
}
