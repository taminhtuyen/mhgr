<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PromotionLogicDictionary extends Model
{
    use HasFactory;

    protected $table = 'promotion_logic_dictionary';

    protected $fillable = [
        'code',
        'name',
        'description',
        'parameters_schema',
        'handler_class',
        'type',
    ];

    protected $casts = [
        'parameters_schema' => 'array',
    ];
}
