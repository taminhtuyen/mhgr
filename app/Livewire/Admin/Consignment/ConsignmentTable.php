<?php

namespace App\Livewire\Admin\Consignment;

use Livewire\Component;
use Livewire\WithPagination;

class ConsignmentTable extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.-consignment.-consignment-table');
    }
}
