<?php

namespace App\Policies;

use App\Models\User;
use App\Models\RewardHistory;
use Illuminate\Auth\Access\HandlesAuthorization;

class RewardHistoryPolicy
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
     * Permission: general.reward-histories.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('general.reward-histories.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, RewardHistory $model): bool
    {
        return $user->hasPermissionTo('general.reward-histories.view');
    }

    /**
     * Quyền tạo mới
     * Permission: general.reward-histories.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('general.reward-histories.create');
    }

    /**
     * Quyền cập nhật
     * Permission: general.reward-histories.edit
     */
    public function update(User $user, RewardHistory $model): bool
    {
        return $user->hasPermissionTo('general.reward-histories.edit');
    }

    /**
     * Quyền xóa
     * Permission: general.reward-histories.delete
     */
    public function delete(User $user, RewardHistory $model): bool
    {
        return $user->hasPermissionTo('general.reward-histories.delete');
    }
}