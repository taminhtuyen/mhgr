<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Cart;
use Illuminate\Auth\Access\HandlesAuthorization;

class CartPolicy
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
     * Permission: sales.carts.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('sales.carts.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, Cart $model): bool
    {
        return $user->hasPermissionTo('sales.carts.view');
    }

    /**
     * Quyền tạo mới
     * Permission: sales.carts.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('sales.carts.create');
    }

    /**
     * Quyền cập nhật
     * Permission: sales.carts.edit
     */
    public function update(User $user, Cart $model): bool
    {
        return $user->hasPermissionTo('sales.carts.edit');
    }

    /**
     * Quyền xóa
     * Permission: sales.carts.delete
     */
    public function delete(User $user, Cart $model): bool
    {
        return $user->hasPermissionTo('sales.carts.delete');
    }
}