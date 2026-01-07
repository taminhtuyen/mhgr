<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail; // Bỏ comment nếu muốn dùng tính năng xác thực email
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens; // Dùng nếu sau này làm API App

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Tên bảng trong cơ sở dữ liệu.
     */
    protected $table = 'users';

    /**
     * Các cột được phép gán dữ liệu (Mass Assignment).
     */
    protected $fillable = [
        'username',
        'name',
        'email',
        'phone',
        'password',
        'user_type', // admin, staff, customer...
        'status',    // 1: Active, 0: Banned
        'two_factor_secret',
        'last_login_at',
        'last_login_ip',
        'owner_id',  // ID ông chủ (nếu là nhân viên)
        'store_name',
    ];

    /**
     * Các cột cần ẩn đi khi trả về dữ liệu (API/JSON).
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
    ];

    /**
     * Định dạng kiểu dữ liệu tự động (Casting).
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed', // Laravel 11 tự động mã hóa password
            'last_login_at' => 'datetime',
            'status' => 'boolean',
        ];
    }

    /* -----------------------------------------------------------------
     * RELATIONSHIPS (Mối quan hệ)
     * -----------------------------------------------------------------
     */

    /**
     * User có nhiều Role (Vai trò).
     * Bảng trung gian: user_roles
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id')
            ->withPivot('current_profit_percentage', 'is_work')
            ->withTimestamps();
    }

    /**
     * User có nhiều quyền được gán TRỰC TIẾP (ngoài quyền của Role).
     * Bảng trung gian: user_permissions
     */
    public function directPermissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'user_permissions', 'user_id', 'permission_id');
    }

    /**
     * User có thể có nhân viên cấp dưới (nếu là ông chủ).
     */
    public function employees(): HasMany
    {
        return $this->hasMany(User::class, 'owner_id', 'id');
    }

    /**
     * User thuộc về một ông chủ (nếu là nhân viên).
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    /* -----------------------------------------------------------------
     * HELPER METHODS (Hàm hỗ trợ Logic)
     * -----------------------------------------------------------------
     */

    /**
     * Kiểm tra user có vai trò cụ thể không.
     * Ví dụ: $user->hasRole('admin_super')
     */
    public function hasRole(string $roleCode): bool
    {
        // Kiểm tra trong danh sách roles đã load xem có code này không
        return $this->roles->contains('code', $roleCode);
    }

    /**
     * Kiểm tra user có quyền cụ thể không.
     * Logic: Check quyền gán riêng TRƯỚC -> Nếu không có thì check quyền theo Role.
     * Ví dụ: $user->hasPermission('product_delete')
     */
    public function hasPermission(string $permissionCode): bool
    {
        // 1. Check quyền gán trực tiếp (user_permissions)
        if ($this->directPermissions->contains('code', $permissionCode)) {
            return true;
        }

        // 2. Check quyền thông qua các Role đang nắm giữ
        foreach ($this->roles as $role) {
            if ($role->permissions->contains('code', $permissionCode)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check xem user có phải là Admin không (dựa trên user_type)
     */
    public function isAdmin(): bool
    {
        return in_array($this->user_type, ['admin', 'staff']); // Bạn có thể tùy chỉnh logic này
    }
}
