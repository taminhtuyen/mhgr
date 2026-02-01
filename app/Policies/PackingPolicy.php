<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Packing;
use Illuminate\Auth\Access\HandlesAuthorization;

class PackingPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability) {
        if (in_array($user->user_type, ['admin_super', 'admin_standard'])) return true;
    }
    public function viewAny(User $user): bool { return $user->hasPermissionTo('inventory.packings.view'); }
    public function create(User $user): bool { return $user->hasPermissionTo('inventory.packings.create'); }
    public function update(User $user, Packing $model): bool { return $user->hasPermissionTo('inventory.packings.edit'); }
    public function delete(User $user, Packing $model): bool { return $user->hasPermissionTo('inventory.packings.delete'); }
}
