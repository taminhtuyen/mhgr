<?php

namespace App\Livewire\Client\Checkout;

use Livewire\Component;
use Livewire\WithPagination;

class CheckoutComponent extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.client.-checkout.-checkout-component');
    }
}
