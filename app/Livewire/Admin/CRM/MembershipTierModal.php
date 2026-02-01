<?php

namespace App\Livewire\Admin\CRM;

use Livewire\Component;

class MembershipTierModal extends Component
{
    public bool $showModal = false;
    public $name;

    protected $listeners = ['showMembershipTierModal' => 'openModal'];

    public function render()
    {
        return view('livewire.admin.crm.membership-tier-modal');
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
