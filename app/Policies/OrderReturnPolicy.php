<?php

namespace App\Policies;

use App\Models\User;
use App\Models\OrderReturn;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderReturnPolicy
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
     * Permission: sales.order-returns.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('sales.order-returns.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, OrderReturn $model): bool
    {
        return $user->hasPermissionTo('sales.order-returns.view');
    }

    /**
     * Quyền tạo mới
     * Permission: sales.order-returns.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('sales.order-returns.create');
    }

    /**
     * Quyền cập nhật
     * Permission: sales.order-returns.edit
     */
    public function update(User $user, OrderReturn $model): bool
    {
        return $user->hasPermissionTo('sales.order-returns.edit');
    }

    /**
     * Quyền xóa
     * Permission: sales.order-returns.delete
     */
    public function delete(User $user, OrderReturn $model): bool
    {
        return $user->hasPermissionTo('sales.order-returns.delete');
    }
}