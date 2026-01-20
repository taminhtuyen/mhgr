<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RewardHistory extends Model
{
    use HasFactory;

    protected $table = 'users_reward_history';
    public $timestamps = false;

    protected $fillable = [
        'wallet_id',
        'amount',
        'type',
        'description',
        'reference_id',
        'balance_after',
        'created_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'balance_after' => 'decimal:2',
        'created_at' => 'datetime',
    ];

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(UserRewardWallet::class, 'wallet_id');
    }
}