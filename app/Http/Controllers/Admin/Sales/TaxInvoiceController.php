<?php

namespace App\Http\Controllers\Admin\Sales;

use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class TaxInvoiceController extends Controller
{
    use HasTableSchema;

    public function index()
    {
        return view('admin.sales.tax-invoices.index', [
            'title' => 'Hóa Đơn VAT'
        ]);
    }
}
