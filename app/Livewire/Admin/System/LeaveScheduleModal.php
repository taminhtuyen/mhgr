<?php

namespace App\Livewire\Admin\System;

use Livewire\Component;

class LeaveScheduleModal extends Component
{
    public bool $showModal = false;
    public $name;

    protected $listeners = ['showLeaveScheduleModal' => 'openModal'];

    public function render()
    {
        return view('livewire.admin.system.leave-schedule-modal');
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
