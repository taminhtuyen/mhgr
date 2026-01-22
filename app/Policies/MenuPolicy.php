<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Menu;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenuPolicy
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
     * Permission: general.menus.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('general.menus.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, Menu $model): bool
    {
        return $user->hasPermissionTo('general.menus.view');
    }

    /**
     * Quyền tạo mới
     * Permission: general.menus.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('general.menus.create');
    }

    /**
     * Quyền cập nhật
     * Permission: general.menus.edit
     */
    public function update(User $user, Menu $model): bool
    {
        return $user->hasPermissionTo('general.menus.edit');
    }

    /**
     * Quyền xóa
     * Permission: general.menus.delete
     */
    public function delete(User $user, Menu $model): bool
    {
        return $user->hasPermissionTo('general.menus.delete');
    }
}