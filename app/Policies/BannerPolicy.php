<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Banner;
use Illuminate\Auth\Access\HandlesAuthorization;

class BannerPolicy
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
     * Permission: marketing.banners.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('marketing.banners.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, Banner $model): bool
    {
        return $user->hasPermissionTo('marketing.banners.view');
    }

    /**
     * Quyền tạo mới
     * Permission: marketing.banners.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('marketing.banners.create');
    }

    /**
     * Quyền cập nhật
     * Permission: marketing.banners.edit
     */
    public function update(User $user, Banner $model): bool
    {
        return $user->hasPermissionTo('marketing.banners.edit');
    }

    /**
     * Quyền xóa
     * Permission: marketing.banners.delete
     */
    public function delete(User $user, Banner $model): bool
    {
        return $user->hasPermissionTo('marketing.banners.delete');
    }
}