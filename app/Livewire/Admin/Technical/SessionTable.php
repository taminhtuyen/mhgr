<?php

namespace App\Livewire\Admin\Technical;

use Livewire\Component;
use Livewire\WithPagination;

class SessionTable extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.technical.session-table');
    }
}
