<?php

namespace App\Policies;

use App\Models\User;
use App\Models\FlashSaleProduct;
use Illuminate\Auth\Access\HandlesAuthorization;

class FlashSaleProductPolicy
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
     * Permission: general.flash-sale-products.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('general.flash-sale-products.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, FlashSaleProduct $model): bool
    {
        return $user->hasPermissionTo('general.flash-sale-products.view');
    }

    /**
     * Quyền tạo mới
     * Permission: general.flash-sale-products.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('general.flash-sale-products.create');
    }

    /**
     * Quyền cập nhật
     * Permission: general.flash-sale-products.edit
     */
    public function update(User $user, FlashSaleProduct $model): bool
    {
        return $user->hasPermissionTo('general.flash-sale-products.edit');
    }

    /**
     * Quyền xóa
     * Permission: general.flash-sale-products.delete
     */
    public function delete(User $user, FlashSaleProduct $model): bool
    {
        return $user->hasPermissionTo('general.flash-sale-products.delete');
    }
}