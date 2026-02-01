<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameAudioFile extends Model
{
    use HasFactory;

    protected $table = 'game_audio_files';

    protected $fillable = [
        'voice_id',
        'content_hash',
        'text',
        'file_path',
        'duration',
        'format',
        'file_size',
    ];

    protected $casts = [
    ];

    public function voice(): BelongsTo
    {
        return $this->belongsTo(GameVoice::class, 'voice_id');
    }
}
