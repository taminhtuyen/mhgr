<?php

namespace App\Livewire\Admin\Catalog;

use Livewire\Component;

class CategoryCollectionModal extends Component
{
    public bool $showModal = false;
    public $name;

    protected $listeners = ['showCategoryCollectionModal' => 'openModal'];

    public function render()
    {
        return view('livewire.admin.catalog.category-collection-modal');
    }

    public function openModal()
    {
        $this->reset();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function save()
    {
        $this->dispatch('refreshTable');
        $this->closeModal();
        $this->dispatch('show-toast', type: 'success', message: 'Thành công!');
    }
}
