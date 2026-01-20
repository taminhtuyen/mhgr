<?php

namespace App\Livewire\Admin\Catalog;

use Livewire\Component;
use Livewire\WithPagination;

class AttributeTable extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.-catalog.-attribute-table');
    }
}
