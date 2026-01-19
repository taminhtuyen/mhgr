<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Affiliate extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'affiliates';

    protected $fillable = [
        'user_id',
        'code',
        'commission_rate',
        'total_referred',
        'total_earnings',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}