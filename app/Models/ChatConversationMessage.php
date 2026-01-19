<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatConversationMessage extends Model
{
    use HasFactory;

    protected $table = 'chat_messages';
    public $timestamps = false;

    protected $fillable = [
        'conversation_id',
        'sender_id',
        'type',
        'content',
        'meta_data',
        'is_deleted',
        'created_at'
    ];

    protected $casts = [
        'is_deleted' => 'boolean',
        'created_at' => 'datetime',
    ];

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(ChatConversationConversation::class, 'conversation_id');
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}