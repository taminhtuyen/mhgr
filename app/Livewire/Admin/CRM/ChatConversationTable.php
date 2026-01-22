<?php

namespace App\Livewire\Admin\CRM;

use Livewire\Component;
use Livewire\WithPagination;

class ChatConversationTable extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.c-r-m.chat-conversation-table');
    }
}
