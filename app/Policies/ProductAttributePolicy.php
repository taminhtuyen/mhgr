<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ProductAttribute;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductAttributePolicy
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
     * Permission: general.product-attributes.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('general.product-attributes.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, ProductAttribute $model): bool
    {
        return $user->hasPermissionTo('general.product-attributes.view');
    }

    /**
     * Quyền tạo mới
     * Permission: general.product-attributes.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('general.product-attributes.create');
    }

    /**
     * Quyền cập nhật
     * Permission: general.product-attributes.edit
     */
    public function update(User $user, ProductAttribute $model): bool
    {
        return $user->hasPermissionTo('general.product-attributes.edit');
    }

    /**
     * Quyền xóa
     * Permission: general.product-attributes.delete
     */
    public function delete(User $user, ProductAttribute $model): bool
    {
        return $user->hasPermissionTo('general.product-attributes.delete');
    }
}