<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Packing extends Model
{
    use HasFactory;

    protected $table = 'packings';

    protected $fillable = [
        'name',
        'description',
        'weight',
        'dimensions',
        'cost',
        'image',
        'status',
    ];

    protected $casts = [
    ];
}
