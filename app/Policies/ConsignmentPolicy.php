<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Consignment;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConsignmentPolicy
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
     * Permission: general.consignments.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('general.consignments.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, Consignment $model): bool
    {
        return $user->hasPermissionTo('general.consignments.view');
    }

    /**
     * Quyền tạo mới
     * Permission: general.consignments.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('general.consignments.create');
    }

    /**
     * Quyền cập nhật
     * Permission: general.consignments.edit
     */
    public function update(User $user, Consignment $model): bool
    {
        return $user->hasPermissionTo('general.consignments.edit');
    }

    /**
     * Quyền xóa
     * Permission: general.consignments.delete
     */
    public function delete(User $user, Consignment $model): bool
    {
        return $user->hasPermissionTo('general.consignments.delete');
    }
}