<?php

namespace App\Livewire\Admin\System;

use Livewire\Component;
use Livewire\WithPagination;

class LocationTable extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.system.location-table');
    }
}
