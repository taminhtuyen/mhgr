<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReviewRatingRule extends Model
{
    use HasFactory;

    protected $table = 'review_rating_rules';

    protected $fillable = [
        'star_rating',
        'reward_points',
        'conditions',
        'status',
    ];

    protected $casts = [
        'conditions' => 'array',
    ];
}
