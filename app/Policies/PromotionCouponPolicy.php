<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PromotionCoupon;
use Illuminate\Auth\Access\HandlesAuthorization;

class PromotionCouponPolicy
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
     * Permission: general.promotion-coupons.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('general.promotion-coupons.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, PromotionCoupon $model): bool
    {
        return $user->hasPermissionTo('general.promotion-coupons.view');
    }

    /**
     * Quyền tạo mới
     * Permission: general.promotion-coupons.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('general.promotion-coupons.create');
    }

    /**
     * Quyền cập nhật
     * Permission: general.promotion-coupons.edit
     */
    public function update(User $user, PromotionCoupon $model): bool
    {
        return $user->hasPermissionTo('general.promotion-coupons.edit');
    }

    /**
     * Quyền xóa
     * Permission: general.promotion-coupons.delete
     */
    public function delete(User $user, PromotionCoupon $model): bool
    {
        return $user->hasPermissionTo('general.promotion-coupons.delete');
    }
}