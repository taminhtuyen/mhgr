<?php

namespace App\Livewire\Admin\Consignment;

use Livewire\Component;
use Livewire\WithPagination;

class ConsignmentCustomerTable extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.consignment.consignment-customer-table');
    }
}
