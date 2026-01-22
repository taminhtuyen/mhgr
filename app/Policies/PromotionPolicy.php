<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Promotion;
use Illuminate\Auth\Access\HandlesAuthorization;

class PromotionPolicy
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
     * Permission: marketing.promotions.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('marketing.promotions.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, Promotion $model): bool
    {
        return $user->hasPermissionTo('marketing.promotions.view');
    }

    /**
     * Quyền tạo mới
     * Permission: marketing.promotions.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('marketing.promotions.create');
    }

    /**
     * Quyền cập nhật
     * Permission: marketing.promotions.edit
     */
    public function update(User $user, Promotion $model): bool
    {
        return $user->hasPermissionTo('marketing.promotions.edit');
    }

    /**
     * Quyền xóa
     * Permission: marketing.promotions.delete
     */
    public function delete(User $user, Promotion $model): bool
    {
        return $user->hasPermissionTo('marketing.promotions.delete');
    }
}