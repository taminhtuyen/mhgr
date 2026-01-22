<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Order;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
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
     * Permission: sales.orders.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('sales.orders.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, Order $model): bool
    {
        return $user->hasPermissionTo('sales.orders.view');
    }

    /**
     * Quyền tạo mới
     * Permission: sales.orders.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('sales.orders.create');
    }

    /**
     * Quyền cập nhật
     * Permission: sales.orders.edit
     */
    public function update(User $user, Order $model): bool
    {
        return $user->hasPermissionTo('sales.orders.edit');
    }

    /**
     * Quyền xóa
     * Permission: sales.orders.delete
     */
    public function delete(User $user, Order $model): bool
    {
        return $user->hasPermissionTo('sales.orders.delete');
    }
}