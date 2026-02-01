<?php

namespace App\Livewire\Admin\Finance;

use Livewire\Component;

class ReviewRatingRuleModal extends Component
{
    public bool $showModal = false;
    public $name;

    protected $listeners = ['showReviewRatingRuleModal' => 'openModal'];

    public function render()
    {
        return view('livewire.admin.finance.review-rating-rule-modal');
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
