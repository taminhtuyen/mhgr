<?php

namespace App\Livewire\Admin\Logistics;

use Livewire\Component;

class DeliveryFailureModal extends Component
{
    public bool $showModal = false;
    public $name;

    protected $listeners = ['showDeliveryFailureModal' => 'openModal'];

    public function render()
    {
        return view('livewire.admin.logistics.delivery-failure-modal');
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
