<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class InvoiceController extends Controller
{
    use HasTableSchema;

    public function index()
    {
        $tableName = 'tax_invoices';

        return view('admin.schema-view', [
            'title' => 'Hóa Đơn VAT',
            'table' => $tableName,
            'columns' => $this->getSchema($tableName)
        ]);
    }
}
