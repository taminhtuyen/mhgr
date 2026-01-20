<?php

namespace App\Livewire\Client\Cart;

use Livewire\Component;
use Livewire\WithPagination;

class CartComponent extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.client.-cart.-cart-component');
    }
}
