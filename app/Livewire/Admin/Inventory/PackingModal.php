<?php

namespace App\Livewire\Admin\Inventory;

use Livewire\Component;

class PackingModal extends Component
{
    public bool $showModal = false;
    public $name;

    protected $listeners = ['showPackingModal' => 'openModal'];

    public function render()
    {
        return view('livewire.admin.inventory.packing-modal');
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
