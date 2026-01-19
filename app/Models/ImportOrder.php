<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ImportOrder extends Model
{
    use HasFactory;

    protected $table = 'import_orders';

    protected $fillable = [
        'code',
        'supplier_id',
        'warehouse_id',
        'creator_id',
        'total_cost',
        'status',
        'note',
        'expected_delivery_date',
    ];

    protected $casts = [
        'expected_delivery_date' => 'date',
        'total_cost' => 'decimal:2',
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(ImportOrderItem::class, 'import_order_id');
    }
}