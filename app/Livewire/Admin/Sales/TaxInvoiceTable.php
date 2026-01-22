<?php

namespace App\Livewire\Admin\Sales;

use Livewire\Component;
use Livewire\WithPagination;

class TaxInvoiceTable extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.sales.tax-invoice-table');
    }
}
