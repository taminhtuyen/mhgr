<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MembershipTier;
use Illuminate\Auth\Access\HandlesAuthorization;

class MembershipTierPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability) {
        if (in_array($user->user_type, ['admin_super', 'admin_standard'])) return true;
    }
    public function viewAny(User $user): bool { return $user->hasPermissionTo('crm.membership-tiers.view'); }
    public function create(User $user): bool { return $user->hasPermissionTo('crm.membership-tiers.create'); }
    public function update(User $user, MembershipTier $model): bool { return $user->hasPermissionTo('crm.membership-tiers.edit'); }
    public function delete(User $user, MembershipTier $model): bool { return $user->hasPermissionTo('crm.membership-tiers.delete'); }
}
