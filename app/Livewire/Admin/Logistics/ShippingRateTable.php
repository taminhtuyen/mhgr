<?php

namespace App\Livewire\Admin\Logistics;

use Livewire\Component;

class ShippingRateTable extends Component
{
    public function render()
    {
        // Chỉ render view, không cần gọi Service hay DB phức tạp
        return view('livewire.admin.logistics.shipping-rate-table');
    }
}