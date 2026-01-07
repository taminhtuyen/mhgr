<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    use HasFactory;

    /**
     * Tên bảng trong cơ sở dữ liệu.
     */
    protected $table = 'permissions';

    /**
     * Các cột được phép gán dữ liệu hàng loạt.
     */
    protected $fillable = [
        'name',
        'code',
        'description',
        'role_group_id',
    ];

    /**
     * Tắt timestamps vì bảng permissions không có created_at/updated_at.
     */
    public $timestamps = false;

    /**
     * Quan hệ: Permission thuộc về nhiều Role.
     * Bảng trung gian: permissions_role
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'permissions_role', 'permission_id', 'role_id');
    }

    /**
     * Quan hệ: Permission được gán trực tiếp cho User (Gán quyền riêng).
     * Bảng trung gian: user_permissions
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_permissions', 'permission_id', 'user_id');
    }
}
