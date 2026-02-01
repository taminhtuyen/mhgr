<?php

namespace App\Livewire\Admin\Technical;

use Livewire\Component;
use Livewire\WithPagination;

class QueueJobTable extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.technical.queue-job-table');
    }
}
