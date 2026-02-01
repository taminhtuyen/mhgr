<?php

namespace App\Livewire\Admin\Catalog;

use Livewire\Component;
use Livewire\WithPagination;

class CategoryCollectionTable extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.catalog.category-collection-table');
    }
}
