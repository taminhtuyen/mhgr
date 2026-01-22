<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class FlashSale extends Model
{
    use HasFactory;

    protected $table = 'flash_sales';

    protected $fillable = [
        'name',
        'start_time',
        'end_time',
        'is_active',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
