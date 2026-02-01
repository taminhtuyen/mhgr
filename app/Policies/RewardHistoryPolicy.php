<?php

namespace App\Policies;

use App\Models\User;
use App\Models\RewardHistory;
use Illuminate\Auth\Access\HandlesAuthorization;

class RewardHistoryPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability) {
        if (in_array($user->user_type, ['admin_super', 'admin_standard'])) return true;
    }
    public function viewAny(User $user): bool { return $user->hasPermissionTo('finance.reward-histories.view'); }
    public function create(User $user): bool { return $user->hasPermissionTo('finance.reward-histories.create'); }
    public function update(User $user, RewardHistory $model): bool { return $user->hasPermissionTo('finance.reward-histories.edit'); }
    public function delete(User $user, RewardHistory $model): bool { return $user->hasPermissionTo('finance.reward-histories.delete'); }
}
