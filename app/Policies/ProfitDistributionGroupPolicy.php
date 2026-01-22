<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ProfitDistributionGroup;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProfitDistributionGroupPolicy
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
     * Permission: general.profit-distribution-groups.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('general.profit-distribution-groups.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, ProfitDistributionGroup $model): bool
    {
        return $user->hasPermissionTo('general.profit-distribution-groups.view');
    }

    /**
     * Quyền tạo mới
     * Permission: general.profit-distribution-groups.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('general.profit-distribution-groups.create');
    }

    /**
     * Quyền cập nhật
     * Permission: general.profit-distribution-groups.edit
     */
    public function update(User $user, ProfitDistributionGroup $model): bool
    {
        return $user->hasPermissionTo('general.profit-distribution-groups.edit');
    }

    /**
     * Quyền xóa
     * Permission: general.profit-distribution-groups.delete
     */
    public function delete(User $user, ProfitDistributionGroup $model): bool
    {
        return $user->hasPermissionTo('general.profit-distribution-groups.delete');
    }
}