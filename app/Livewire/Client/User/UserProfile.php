<?php

namespace App\Livewire\Client\User;

use Livewire\Component;
use Livewire\WithPagination;

class UserProfile extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.client.-user.-user-profile');
    }
}
