<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameLanguage extends Model
{
    use HasFactory;

    protected $table = 'game_languages';

    protected $fillable = [
        'code',
        'name',
        'flag_icon',
        'is_active',
        'is_default',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_default' => 'boolean',
    ];

    public $timestamps = false;
}
