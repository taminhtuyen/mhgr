<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Warehouse extends Model
{
    use HasFactory;

    protected $table = 'warehouses';

    protected $fillable = [
        'name',
        'code',
        'type',
        'address',
        'province_id',
        'ward_id',
        'is_active',
    ];

    public function inventoryStocks(): HasMany
    {
        return $this->hasMany(InventoryStock::class, 'warehouse_id');
    }
}