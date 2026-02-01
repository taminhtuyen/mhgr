<?php

namespace App\Livewire\Admin\Logistics;

use Livewire\Component;
use Livewire\WithPagination;

class DeliveryFailureTable extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.logistics.delivery-failure-table');
    }
}
