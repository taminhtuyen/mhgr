<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameVoice extends Model
{
    use HasFactory;

    protected $table = 'game_voices';

    protected $fillable = [
        'language_id',
        'name',
        'gender',
        'voice_code',
        'provider',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function language(): BelongsTo
    {
        return $this->belongsTo(GameLanguage::class, 'language_id');
    }

    public $timestamps = false;
}
