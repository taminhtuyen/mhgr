<?php

namespace App\Policies;

use App\Models\User;
use App\Models\FlashSale;
use Illuminate\Auth\Access\HandlesAuthorization;

class FlashSalePolicy
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
     * Permission: marketing.flash-sales.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('marketing.flash-sales.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, FlashSale $model): bool
    {
        return $user->hasPermissionTo('marketing.flash-sales.view');
    }

    /**
     * Quyền tạo mới
     * Permission: marketing.flash-sales.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('marketing.flash-sales.create');
    }

    /**
     * Quyền cập nhật
     * Permission: marketing.flash-sales.edit
     */
    public function update(User $user, FlashSale $model): bool
    {
        return $user->hasPermissionTo('marketing.flash-sales.edit');
    }

    /**
     * Quyền xóa
     * Permission: marketing.flash-sales.delete
     */
    public function delete(User $user, FlashSale $model): bool
    {
        return $user->hasPermissionTo('marketing.flash-sales.delete');
    }
}