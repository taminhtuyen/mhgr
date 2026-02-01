<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserCustomerProfile extends Model
{
    use HasFactory;

    protected $table = 'users_customer_profiles';

    protected $fillable = [
        'user_id',
        'membership_tier_id',
        'loyalty_points',
        'total_spent',
        'dob',
        'gender',
        'referral_code',
        'referred_by',
        'last_purchase_at',
        'preferences',
    ];

    protected $casts = [
        'last_purchase_at' => 'datetime',
        'preferences' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function membershipTier(): BelongsTo
    {
        return $this->belongsTo(MembershipTier::class, 'membership_tier_id');
    }

    public function referredBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referred_by');
    }
}
