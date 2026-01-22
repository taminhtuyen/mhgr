<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CustomerRequest;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerRequestPolicy
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
     * Permission: general.customer-requests.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('general.customer-requests.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, CustomerRequest $model): bool
    {
        return $user->hasPermissionTo('general.customer-requests.view');
    }

    /**
     * Quyền tạo mới
     * Permission: general.customer-requests.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('general.customer-requests.create');
    }

    /**
     * Quyền cập nhật
     * Permission: general.customer-requests.edit
     */
    public function update(User $user, CustomerRequest $model): bool
    {
        return $user->hasPermissionTo('general.customer-requests.edit');
    }

    /**
     * Quyền xóa
     * Permission: general.customer-requests.delete
     */
    public function delete(User $user, CustomerRequest $model): bool
    {
        return $user->hasPermissionTo('general.customer-requests.delete');
    }
}