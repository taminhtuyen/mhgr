<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * BỘ LỌC ADMIN (SUPER & STANDARD)
     * Hiện tại: Cả 2 loại admin đều có quyền tuyệt đối (bypass check).
     * Sau này: Nếu muốn cắt quyền admin_standard, chỉ cần xóa khỏi mảng bên dưới.
     */
    public function before(User $user, $ability)
    {
        if (in_array($user->user_type, ['admin_super', 'admin_standard'])) {
            return true;
        }
    }

    /**
     * Quyền xem danh sách
     * Permission: system.roles.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('system.roles.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, Role $model): bool
    {
        return $user->hasPermissionTo('system.roles.view');
    }

    /**
     * Quyền tạo mới
     * Permission: system.roles.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('system.roles.create');
    }

    /**
     * Quyền cập nhật
     * Permission: system.roles.edit
     */
    public function update(User $user, Role $model): bool
    {
        return $user->hasPermissionTo('system.roles.edit');
    }

    /**
     * Quyền xóa
     * Permission: system.roles.delete
     */
    public function delete(User $user, Role $model): bool
    {
        return $user->hasPermissionTo('system.roles.delete');
    }
}