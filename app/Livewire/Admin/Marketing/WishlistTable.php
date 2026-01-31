<?php

namespace App\Livewire\Admin\Marketing;

use Livewire\Component;

class WishlistTable extends Component
{
    public function render()
    {
        // Chỉ render view, không cần gọi Service hay DB phức tạp
        return view('livewire.admin.marketing.wishlist-table');
    }
}