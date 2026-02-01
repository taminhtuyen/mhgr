<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PromotionRule extends Model
{
    use HasFactory;

    protected $table = 'promotion_rules';

    protected $fillable = [
        'promotion_id',
        'rule_type',
        'conditions',
        'actions',
        'sort_order',
    ];

    protected $casts = [
        'conditions' => 'array',
        'actions' => 'array',
    ];

    public function promotion(): BelongsTo
    {
        return $this->belongsTo(Promotion::class, 'promotion_id');
    }
}
