<?php

namespace App\Policies;

use App\Models\User;
use App\Models\OrderTransaction;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderTransactionPolicy
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
     * Permission: general.order-transactions.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('general.order-transactions.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, OrderTransaction $model): bool
    {
        return $user->hasPermissionTo('general.order-transactions.view');
    }

    /**
     * Quyền tạo mới
     * Permission: general.order-transactions.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('general.order-transactions.create');
    }

    /**
     * Quyền cập nhật
     * Permission: general.order-transactions.edit
     */
    public function update(User $user, OrderTransaction $model): bool
    {
        return $user->hasPermissionTo('general.order-transactions.edit');
    }

    /**
     * Quyền xóa
     * Permission: general.order-transactions.delete
     */
    public function delete(User $user, OrderTransaction $model): bool
    {
        return $user->hasPermissionTo('general.order-transactions.delete');
    }
}