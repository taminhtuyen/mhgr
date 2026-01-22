<?php

namespace App\Livewire\Admin\Sales;

use Livewire\Component;
use Livewire\WithPagination;

class ShippingShipmentTable extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.sales.shipping-shipment-table');
    }
}
