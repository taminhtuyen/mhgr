<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Image;
use Illuminate\Auth\Access\HandlesAuthorization;

class ImagePolicy
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
     * Permission: general.images.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('general.images.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, Image $model): bool
    {
        return $user->hasPermissionTo('general.images.view');
    }

    /**
     * Quyền tạo mới
     * Permission: general.images.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('general.images.create');
    }

    /**
     * Quyền cập nhật
     * Permission: general.images.edit
     */
    public function update(User $user, Image $model): bool
    {
        return $user->hasPermissionTo('general.images.edit');
    }

    /**
     * Quyền xóa
     * Permission: general.images.delete
     */
    public function delete(User $user, Image $model): bool
    {
        return $user->hasPermissionTo('general.images.delete');
    }
}