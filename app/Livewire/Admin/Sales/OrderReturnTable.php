<?php

namespace App\Livewire\Admin\Sales;

use Livewire\Component;
use Livewire\WithPagination;

class OrderReturnTable extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.sales.order-return-table');
    }
}
