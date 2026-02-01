<?php

namespace App\Policies;

use App\Models\User;
use App\Models\DeliveryFailure;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeliveryFailurePolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability) {
        if (in_array($user->user_type, ['admin_super', 'admin_standard'])) return true;
    }
    public function viewAny(User $user): bool { return $user->hasPermissionTo('logistics.delivery-failures.view'); }
    public function create(User $user): bool { return $user->hasPermissionTo('logistics.delivery-failures.create'); }
    public function update(User $user, DeliveryFailure $model): bool { return $user->hasPermissionTo('logistics.delivery-failures.edit'); }
    public function delete(User $user, DeliveryFailure $model): bool { return $user->hasPermissionTo('logistics.delivery-failures.delete'); }
}
