<?php

namespace App\Livewire\Client\Home;

use Livewire\Component;
use Livewire\WithPagination;

class HomeComponent extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.client.-home.-home-component');
    }
}
