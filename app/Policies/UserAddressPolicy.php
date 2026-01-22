<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserAddressPolicy
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
     * Permission: general.user-addresses.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('general.user-addresses.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, UserAddress $model): bool
    {
        return $user->hasPermissionTo('general.user-addresses.view');
    }

    /**
     * Quyền tạo mới
     * Permission: general.user-addresses.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('general.user-addresses.create');
    }

    /**
     * Quyền cập nhật
     * Permission: general.user-addresses.edit
     */
    public function update(User $user, UserAddress $model): bool
    {
        return $user->hasPermissionTo('general.user-addresses.edit');
    }

    /**
     * Quyền xóa
     * Permission: general.user-addresses.delete
     */
    public function delete(User $user, UserAddress $model): bool
    {
        return $user->hasPermissionTo('general.user-addresses.delete');
    }
}