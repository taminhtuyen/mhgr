<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AffiliateCommission;
use Illuminate\Auth\Access\HandlesAuthorization;

class AffiliateCommissionPolicy
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
     * Permission: general.affiliate-commissions.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('general.affiliate-commissions.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, AffiliateCommission $model): bool
    {
        return $user->hasPermissionTo('general.affiliate-commissions.view');
    }

    /**
     * Quyền tạo mới
     * Permission: general.affiliate-commissions.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('general.affiliate-commissions.create');
    }

    /**
     * Quyền cập nhật
     * Permission: general.affiliate-commissions.edit
     */
    public function update(User $user, AffiliateCommission $model): bool
    {
        return $user->hasPermissionTo('general.affiliate-commissions.edit');
    }

    /**
     * Quyền xóa
     * Permission: general.affiliate-commissions.delete
     */
    public function delete(User $user, AffiliateCommission $model): bool
    {
        return $user->hasPermissionTo('general.affiliate-commissions.delete');
    }
}