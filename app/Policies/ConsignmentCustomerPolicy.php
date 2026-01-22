<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ConsignmentCustomer;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConsignmentCustomerPolicy
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
     * Permission: general.consignment-customers.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('general.consignment-customers.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, ConsignmentCustomer $model): bool
    {
        return $user->hasPermissionTo('general.consignment-customers.view');
    }

    /**
     * Quyền tạo mới
     * Permission: general.consignment-customers.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('general.consignment-customers.create');
    }

    /**
     * Quyền cập nhật
     * Permission: general.consignment-customers.edit
     */
    public function update(User $user, ConsignmentCustomer $model): bool
    {
        return $user->hasPermissionTo('general.consignment-customers.edit');
    }

    /**
     * Quyền xóa
     * Permission: general.consignment-customers.delete
     */
    public function delete(User $user, ConsignmentCustomer $model): bool
    {
        return $user->hasPermissionTo('general.consignment-customers.delete');
    }
}