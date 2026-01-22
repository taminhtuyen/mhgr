<?php

namespace App\Livewire\Admin\Inventory;

use Livewire\Component;
use Livewire\WithPagination;

class ImportOrderTable extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.inventory.import-order-table');
    }
}
