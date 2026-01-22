<?php

namespace App\Policies;

use App\Models\User;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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
     * Permission: system.users.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('system.users.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, User $model): bool
    {
        return $user->hasPermissionTo('system.users.view');
    }

    /**
     * Quyền tạo mới
     * Permission: system.users.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('system.users.create');
    }

    /**
     * Quyền cập nhật
     * Permission: system.users.edit
     */
    public function update(User $user, User $model): bool
    {
        return $user->hasPermissionTo('system.users.edit');
    }

    /**
     * Quyền xóa
     * Permission: system.users.delete
     */
    public function delete(User $user, User $model): bool
    {
        return $user->hasPermissionTo('system.users.delete');
    }
}