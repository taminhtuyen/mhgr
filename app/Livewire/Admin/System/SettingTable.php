<?php

namespace App\Livewire\Admin\System;

use Livewire\Component;
use Livewire\WithPagination;

class SettingTable extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.-system.-setting-table');
    }
}
