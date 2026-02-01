<?php

namespace App\Livewire\Admin\Technical;

use Livewire\Component;

class SessionModal extends Component
{
    public bool $showModal = false;
    public $name;

    protected $listeners = ['showSessionModal' => 'openModal'];

    public function render()
    {
        return view('livewire.admin.technical.session-modal');
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
