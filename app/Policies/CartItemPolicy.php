<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CartItem;
use Illuminate\Auth\Access\HandlesAuthorization;

class CartItemPolicy
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
     * Permission: general.cart-items.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('general.cart-items.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, CartItem $model): bool
    {
        return $user->hasPermissionTo('general.cart-items.view');
    }

    /**
     * Quyền tạo mới
     * Permission: general.cart-items.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('general.cart-items.create');
    }

    /**
     * Quyền cập nhật
     * Permission: general.cart-items.edit
     */
    public function update(User $user, CartItem $model): bool
    {
        return $user->hasPermissionTo('general.cart-items.edit');
    }

    /**
     * Quyền xóa
     * Permission: general.cart-items.delete
     */
    public function delete(User $user, CartItem $model): bool
    {
        return $user->hasPermissionTo('general.cart-items.delete');
    }
}