<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAdminProfile extends Model
{
    use HasFactory;

    protected $table = 'users_admin_profiles';

    protected $fillable = [
        'user_id',
        'department_id',
        'employee_code',
        'position',
        'start_date',
        'end_date',
        'contract_type',
        'salary_coefficient',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
