<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ProductVariation;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductVariationPolicy
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
     * Permission: general.product-variations.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('general.product-variations.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, ProductVariation $model): bool
    {
        return $user->hasPermissionTo('general.product-variations.view');
    }

    /**
     * Quyền tạo mới
     * Permission: general.product-variations.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('general.product-variations.create');
    }

    /**
     * Quyền cập nhật
     * Permission: general.product-variations.edit
     */
    public function update(User $user, ProductVariation $model): bool
    {
        return $user->hasPermissionTo('general.product-variations.edit');
    }

    /**
     * Quyền xóa
     * Permission: general.product-variations.delete
     */
    public function delete(User $user, ProductVariation $model): bool
    {
        return $user->hasPermissionTo('general.product-variations.delete');
    }
}