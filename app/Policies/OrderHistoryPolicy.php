<?php

namespace App\Policies;

use App\Models\User;
use App\Models\OrderHistory;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderHistoryPolicy
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
     * Permission: general.order-histories.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('general.order-histories.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, OrderHistory $model): bool
    {
        return $user->hasPermissionTo('general.order-histories.view');
    }

    /**
     * Quyền tạo mới
     * Permission: general.order-histories.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('general.order-histories.create');
    }

    /**
     * Quyền cập nhật
     * Permission: general.order-histories.edit
     */
    public function update(User $user, OrderHistory $model): bool
    {
        return $user->hasPermissionTo('general.order-histories.edit');
    }

    /**
     * Quyền xóa
     * Permission: general.order-histories.delete
     */
    public function delete(User $user, OrderHistory $model): bool
    {
        return $user->hasPermissionTo('general.order-histories.delete');
    }
}