<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ConsignmentCustomer extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'consignment_customers';

    protected $fillable = [
        'customer_id',
        'note',
        'money_base',
        'current_debt',
        'last_order_time',
        'is_draft',
    ];

}