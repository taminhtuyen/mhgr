<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackingDetail extends Model
{
    use HasFactory;

    protected $table = 'packing_detail';

    protected $fillable = [
        'packing_id',
        'product_id',
        'quantity',
    ];

    protected $casts = [
    ];

    public function packing(): BelongsTo
    {
        return $this->belongsTo(Packing::class, 'packing_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public $timestamps = false;
}
