<?php

namespace App\Livewire\Admin\Marketing;

use Livewire\Component;
use Livewire\WithPagination;

class AffiliateLinkTable extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.marketing.affiliate-link-table');
    }
}
