<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaxTaxInvoice extends Model
{
    use HasFactory;

    protected $table = 'tax_invoices';

    protected $fillable = [
        'order_id',
        'invoice_number',
        'tax_code',
        'company_name',
        'company_address',
        'subtotal',
        'total_tax',
        'total_amount',
        'status',
        'issued_at',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
        'subtotal' => 'decimal:2',
        'total_tax' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}