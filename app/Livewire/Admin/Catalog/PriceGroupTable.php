<?php

namespace App\Livewire\Admin\Catalog;

use Livewire\Component;

class PriceGroupTable extends Component
{
    public function render()
    {
        // Chỉ render view, không cần gọi Service hay DB phức tạp
        return view('livewire.admin.catalog.price-group-table');
    }
}