<?php

namespace App\Livewire\Admin\Content;

use Livewire\Component;

class GameLanguageModal extends Component
{
    public bool $showModal = false;
    public $name;

    protected $listeners = ['showGameLanguageModal' => 'openModal'];

    public function render()
    {
        return view('livewire.admin.content.game-language-modal');
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
