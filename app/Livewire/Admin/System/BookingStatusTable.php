<?php

namespace App\Livewire\Admin\System;

use Livewire\Component;

class BookingStatusTable extends Component
{
    public function render()
    {
        // Chỉ render view, không cần gọi Service hay DB phức tạp
        return view('livewire.admin.system.booking-status-table');
    }
}