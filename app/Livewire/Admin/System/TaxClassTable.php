<?php

namespace App\Livewire\Admin\System;

use Livewire\Component;

class TaxClassTable extends Component
{
    public function render()
    {
        // Chỉ render view, không cần gọi Service hay DB phức tạp
        return view('livewire.admin.system.tax-class-table');
    }
}