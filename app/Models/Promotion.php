<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Promotion extends Model
{
    use HasFactory;

    protected $table = 'promotions';

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'start_at',
        'end_at',
        'status',
        'usage_limit_total',
        'usage_count_total',
        'usage_limit_per_customer',
    ];

}