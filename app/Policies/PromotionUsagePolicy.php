<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PromotionUsage;
use Illuminate\Auth\Access\HandlesAuthorization;

class PromotionUsagePolicy
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
     * Permission: general.promotion-usages.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('general.promotion-usages.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, PromotionUsage $model): bool
    {
        return $user->hasPermissionTo('general.promotion-usages.view');
    }

    /**
     * Quyền tạo mới
     * Permission: general.promotion-usages.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('general.promotion-usages.create');
    }

    /**
     * Quyền cập nhật
     * Permission: general.promotion-usages.edit
     */
    public function update(User $user, PromotionUsage $model): bool
    {
        return $user->hasPermissionTo('general.promotion-usages.edit');
    }

    /**
     * Quyền xóa
     * Permission: general.promotion-usages.delete
     */
    public function delete(User $user, PromotionUsage $model): bool
    {
        return $user->hasPermissionTo('general.promotion-usages.delete');
    }
}