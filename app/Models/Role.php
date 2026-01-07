<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    /**
     * Tên bảng trong cơ sở dữ liệu.
     */
    protected $table = 'roles';

    /**
     * Các cột được phép gán dữ liệu hàng loạt.
     */
    protected $fillable = [
        'name',
        'code',
        'description',
    ];

    /**
     * Tắt timestamps (created_at, updated_at) vì bảng roles trong SQL của bạn
     * không có 2 cột này (dựa theo cấu trúc CREATE TABLE roles).
     * Nếu sau này bạn thêm cột timestamp vào bảng roles thì xóa dòng này đi.
     */
    public $timestamps = false;

    /**
     * Quan hệ: Một Role có nhiều User.
     * Bảng trung gian: user_roles
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_roles', 'role_id', 'user_id')
            ->withPivot('current_profit_percentage', 'is_work') // Lấy thêm cột phụ trong bảng trung gian
            ->withTimestamps();
    }

    /**
     * Quan hệ: Một Role có nhiều Permission.
     * Bảng trung gian: permissions_role
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'permissions_role', 'role_id', 'permission_id');
    }
}
