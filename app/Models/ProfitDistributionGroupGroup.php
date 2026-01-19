<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProfitDistributionGroupGroup extends Model
{
    use HasFactory;

    protected $table = 'profit_distribution_groups';

    protected $fillable = [
        'name',
        'percentage',
        'description',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'percentage' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function members(): HasMany
    {
        return $this->hasMany(ProfitDistributionGroupGroupMember::class, 'group_id');
    }

    public function roles(): HasMany
    {
        return $this->hasMany(ProfitDistributionGroupGroupRole::class, 'group_id');
    }
}