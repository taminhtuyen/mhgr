<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SystemLog;
use Illuminate\Auth\Access\HandlesAuthorization;

class SystemLogPolicy
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
     * Permission: system.system-logs.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('system.system-logs.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, SystemLog $model): bool
    {
        return $user->hasPermissionTo('system.system-logs.view');
    }

    /**
     * Quyền tạo mới
     * Permission: system.system-logs.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('system.system-logs.create');
    }

    /**
     * Quyền cập nhật
     * Permission: system.system-logs.edit
     */
    public function update(User $user, SystemLog $model): bool
    {
        return $user->hasPermissionTo('system.system-logs.edit');
    }

    /**
     * Quyền xóa
     * Permission: system.system-logs.delete
     */
    public function delete(User $user, SystemLog $model): bool
    {
        return $user->hasPermissionTo('system.system-logs.delete');
    }
}