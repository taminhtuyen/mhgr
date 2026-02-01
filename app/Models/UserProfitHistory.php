<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfitHistory extends Model
{
    use HasFactory;

    protected $table = 'user_profit_percentage_history';

    protected $fillable = [
        'user_id',
        'old_percentage',
        'new_percentage',
        'changed_by',
        'reason',
    ];

    protected $casts = [
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
