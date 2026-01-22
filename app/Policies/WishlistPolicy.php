<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Auth\Access\HandlesAuthorization;

class WishlistPolicy
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
     * Permission: general.wishlists.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('general.wishlists.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, Wishlist $model): bool
    {
        return $user->hasPermissionTo('general.wishlists.view');
    }

    /**
     * Quyền tạo mới
     * Permission: general.wishlists.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('general.wishlists.create');
    }

    /**
     * Quyền cập nhật
     * Permission: general.wishlists.edit
     */
    public function update(User $user, Wishlist $model): bool
    {
        return $user->hasPermissionTo('general.wishlists.edit');
    }

    /**
     * Quyền xóa
     * Permission: general.wishlists.delete
     */
    public function delete(User $user, Wishlist $model): bool
    {
        return $user->hasPermissionTo('general.wishlists.delete');
    }
}