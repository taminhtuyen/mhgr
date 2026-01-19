<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


class User extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'users';

    protected $fillable = [
        'username',
        'name',
        'email',
        'phone',
        'password',
        'user_type',
        'status',
        'two_factor_secret',
        'last_login_at',
        'last_login_ip',
        'owner_id',
        'store_name',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
    public function userAddresses(): HasMany
    {
        return $this->hasMany(UserAddress::class, 'user_id');
    }
    public function wallet(): HasOne
    {
        return $this->hasOne(RewardWallet::class, 'user_id');
    }
}