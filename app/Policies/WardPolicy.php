<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Ward;
use Illuminate\Auth\Access\HandlesAuthorization;

class WardPolicy
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
     * Permission: general.wards.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('general.wards.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, Ward $model): bool
    {
        return $user->hasPermissionTo('general.wards.view');
    }

    /**
     * Quyền tạo mới
     * Permission: general.wards.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('general.wards.create');
    }

    /**
     * Quyền cập nhật
     * Permission: general.wards.edit
     */
    public function update(User $user, Ward $model): bool
    {
        return $user->hasPermissionTo('general.wards.edit');
    }

    /**
     * Quyền xóa
     * Permission: general.wards.delete
     */
    public function delete(User $user, Ward $model): bool
    {
        return $user->hasPermissionTo('general.wards.delete');
    }
}