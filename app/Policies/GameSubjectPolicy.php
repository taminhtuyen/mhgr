<?php

namespace App\Policies;

use App\Models\User;
use App\Models\GameSubject;
use Illuminate\Auth\Access\HandlesAuthorization;

class GameSubjectPolicy
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
     * Permission: general.game-subjects.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('general.game-subjects.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, GameSubject $model): bool
    {
        return $user->hasPermissionTo('general.game-subjects.view');
    }

    /**
     * Quyền tạo mới
     * Permission: general.game-subjects.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('general.game-subjects.create');
    }

    /**
     * Quyền cập nhật
     * Permission: general.game-subjects.edit
     */
    public function update(User $user, GameSubject $model): bool
    {
        return $user->hasPermissionTo('general.game-subjects.edit');
    }

    /**
     * Quyền xóa
     * Permission: general.game-subjects.delete
     */
    public function delete(User $user, GameSubject $model): bool
    {
        return $user->hasPermissionTo('general.game-subjects.delete');
    }
}