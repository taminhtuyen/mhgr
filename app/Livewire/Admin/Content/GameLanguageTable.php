<?php

namespace App\Livewire\Admin\Content;

use Livewire\Component;
use Livewire\WithPagination;

class GameLanguageTable extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.content.game-language-table');
    }
}
