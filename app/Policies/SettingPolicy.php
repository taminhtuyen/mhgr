<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingPolicy
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
     * Permission: system.settings.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('system.settings.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, Setting $model): bool
    {
        return $user->hasPermissionTo('system.settings.view');
    }

    /**
     * Quyền tạo mới
     * Permission: system.settings.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('system.settings.create');
    }

    /**
     * Quyền cập nhật
     * Permission: system.settings.edit
     */
    public function update(User $user, Setting $model): bool
    {
        return $user->hasPermissionTo('system.settings.edit');
    }

    /**
     * Quyền xóa
     * Permission: system.settings.delete
     */
    public function delete(User $user, Setting $model): bool
    {
        return $user->hasPermissionTo('system.settings.delete');
    }
}