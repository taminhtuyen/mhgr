<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PromotionPromotionCoupon extends Model
{
    use HasFactory;

    protected $table = 'promotion_coupons';

    protected $fillable = [
        'promotion_id',
        'promotion_rule_id',
        'code',
        'user_id',
        'claimed_at',
        'source_type',
        'batch_name',
        'usage_limit',
        'usage_count',
        'status',
        'expired_at',
    ];

    protected $casts = [
        'claimed_at' => 'datetime',
        'expired_at' => 'datetime',
        'status' => 'boolean',
    ];

    public function promotion(): BelongsTo
    {
        return $this->belongsTo(Promotion::class, 'promotion_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}