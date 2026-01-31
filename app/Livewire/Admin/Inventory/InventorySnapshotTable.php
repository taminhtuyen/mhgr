<?php

namespace App\Livewire\Admin\Inventory;

use Livewire\Component;

class InventorySnapshotTable extends Component
{
    public function render()
    {
        // Chỉ render view, không cần gọi Service hay DB phức tạp
        return view('livewire.admin.inventory.inventory-snapshot-table');
    }
}