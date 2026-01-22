<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Province;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProvincePolicy
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
     * Permission: general.provinces.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('general.provinces.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, Province $model): bool
    {
        return $user->hasPermissionTo('general.provinces.view');
    }

    /**
     * Quyền tạo mới
     * Permission: general.provinces.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('general.provinces.create');
    }

    /**
     * Quyền cập nhật
     * Permission: general.provinces.edit
     */
    public function update(User $user, Province $model): bool
    {
        return $user->hasPermissionTo('general.provinces.edit');
    }

    /**
     * Quyền xóa
     * Permission: general.provinces.delete
     */
    public function delete(User $user, Province $model): bool
    {
        return $user->hasPermissionTo('general.provinces.delete');
    }
}