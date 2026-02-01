<?php

namespace App\Livewire\Admin\Marketing;

use Livewire\Component;

class SearchHistoryModal extends Component
{
    public bool $showModal = false;
    public $name;

    protected $listeners = ['showSearchHistoryModal' => 'openModal'];

    public function render()
    {
        return view('livewire.admin.marketing.search-history-modal');
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
