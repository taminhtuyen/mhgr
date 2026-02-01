<?php

namespace App\Livewire\Admin\CRM;

use Livewire\Component;
use Livewire\WithPagination;

class MembershipTierTable extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.crm.membership-tier-table');
    }
}
