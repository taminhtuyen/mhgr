<?php

namespace App\Livewire\Admin\Inventory;

use Livewire\Component;
use Livewire\WithPagination;

class WarehouseTable extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.inventory.warehouse-table');
    }
}
