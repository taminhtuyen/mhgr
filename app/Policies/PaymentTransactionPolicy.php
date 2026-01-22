<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PaymentTransaction;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaymentTransactionPolicy
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
     * Permission: general.payment-transactions.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('general.payment-transactions.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, PaymentTransaction $model): bool
    {
        return $user->hasPermissionTo('general.payment-transactions.view');
    }

    /**
     * Quyền tạo mới
     * Permission: general.payment-transactions.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('general.payment-transactions.create');
    }

    /**
     * Quyền cập nhật
     * Permission: general.payment-transactions.edit
     */
    public function update(User $user, PaymentTransaction $model): bool
    {
        return $user->hasPermissionTo('general.payment-transactions.edit');
    }

    /**
     * Quyền xóa
     * Permission: general.payment-transactions.delete
     */
    public function delete(User $user, PaymentTransaction $model): bool
    {
        return $user->hasPermissionTo('general.payment-transactions.delete');
    }
}