<?php

namespace App\Livewire\Client\Product;

use Livewire\Component;
use Livewire\WithPagination;

class ProductDetail extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.client.-product.-product-detail');
    }
}
