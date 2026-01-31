<?php

namespace App\Livewire\Admin\Logistics;

use Livewire\Component;

class DeliveryTripTable extends Component
{
    public function render()
    {
        // Chỉ render view, không cần gọi Service hay DB phức tạp
        return view('livewire.admin.logistics.delivery-trip-table');
    }
}