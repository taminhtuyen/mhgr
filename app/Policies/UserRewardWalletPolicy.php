<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserRewardWallet;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserRewardWalletPolicy
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
     * Permission: general.user-reward-wallets.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('general.user-reward-wallets.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, UserRewardWallet $model): bool
    {
        return $user->hasPermissionTo('general.user-reward-wallets.view');
    }

    /**
     * Quyền tạo mới
     * Permission: general.user-reward-wallets.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('general.user-reward-wallets.create');
    }

    /**
     * Quyền cập nhật
     * Permission: general.user-reward-wallets.edit
     */
    public function update(User $user, UserRewardWallet $model): bool
    {
        return $user->hasPermissionTo('general.user-reward-wallets.edit');
    }

    /**
     * Quyền xóa
     * Permission: general.user-reward-wallets.delete
     */
    public function delete(User $user, UserRewardWallet $model): bool
    {
        return $user->hasPermissionTo('general.user-reward-wallets.delete');
    }
}