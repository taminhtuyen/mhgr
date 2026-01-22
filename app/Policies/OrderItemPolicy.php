<?php

namespace App\Policies;

use App\Models\User;
use App\Models\OrderItem;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderItemPolicy
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
     * Permission: sales.order-items.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('sales.order-items.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, OrderItem $model): bool
    {
        return $user->hasPermissionTo('sales.order-items.view');
    }

    /**
     * Quyền tạo mới
     * Permission: sales.order-items.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('sales.order-items.create');
    }

    /**
     * Quyền cập nhật
     * Permission: sales.order-items.edit
     */
    public function update(User $user, OrderItem $model): bool
    {
        return $user->hasPermissionTo('sales.order-items.edit');
    }

    /**
     * Quyền xóa
     * Permission: sales.order-items.delete
     */
    public function delete(User $user, OrderItem $model): bool
    {
        return $user->hasPermissionTo('sales.order-items.delete');
    }
}