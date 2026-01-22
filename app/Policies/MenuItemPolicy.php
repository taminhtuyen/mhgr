<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MenuItem;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenuItemPolicy
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
     * Permission: general.menu-items.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('general.menu-items.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, MenuItem $model): bool
    {
        return $user->hasPermissionTo('general.menu-items.view');
    }

    /**
     * Quyền tạo mới
     * Permission: general.menu-items.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('general.menu-items.create');
    }

    /**
     * Quyền cập nhật
     * Permission: general.menu-items.edit
     */
    public function update(User $user, MenuItem $model): bool
    {
        return $user->hasPermissionTo('general.menu-items.edit');
    }

    /**
     * Quyền xóa
     * Permission: general.menu-items.delete
     */
    public function delete(User $user, MenuItem $model): bool
    {
        return $user->hasPermissionTo('general.menu-items.delete');
    }
}