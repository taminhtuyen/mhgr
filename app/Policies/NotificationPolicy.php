<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotificationPolicy
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
     * Permission: general.notifications.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('general.notifications.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, Notification $model): bool
    {
        return $user->hasPermissionTo('general.notifications.view');
    }

    /**
     * Quyền tạo mới
     * Permission: general.notifications.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('general.notifications.create');
    }

    /**
     * Quyền cập nhật
     * Permission: general.notifications.edit
     */
    public function update(User $user, Notification $model): bool
    {
        return $user->hasPermissionTo('general.notifications.edit');
    }

    /**
     * Quyền xóa
     * Permission: general.notifications.delete
     */
    public function delete(User $user, Notification $model): bool
    {
        return $user->hasPermissionTo('general.notifications.delete');
    }
}