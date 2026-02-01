<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PromotionRuleProduct extends Model
{
    use HasFactory;

    protected $table = 'promotion_rule_products';

    protected $fillable = [
        'promotion_rule_id',
        'product_id',
        'variation_id',
        'excluded',
    ];

    protected $casts = [
        'excluded' => 'boolean',
    ];

    public function promotionRule(): BelongsTo
    {
        return $this->belongsTo(PromotionRule::class, 'promotion_rule_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function variation(): BelongsTo
    {
        return $this->belongsTo(ProductVariation::class, 'variation_id');
    }
}
