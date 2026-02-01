<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Pulse;
use Illuminate\Auth\Access\HandlesAuthorization;

class PulsePolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability) {
        if (in_array($user->user_type, ['admin_super', 'admin_standard'])) return true;
    }
    public function viewAny(User $user): bool { return $user->hasPermissionTo('technical.pulses.view'); }
    public function create(User $user): bool { return $user->hasPermissionTo('technical.pulses.create'); }
    public function update(User $user, Pulse $model): bool { return $user->hasPermissionTo('technical.pulses.edit'); }
    public function delete(User $user, Pulse $model): bool { return $user->hasPermissionTo('technical.pulses.delete'); }
}
