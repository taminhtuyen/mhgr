<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Session;
use Illuminate\Auth\Access\HandlesAuthorization;

class SessionPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability) {
        if (in_array($user->user_type, ['admin_super', 'admin_standard'])) return true;
    }
    public function viewAny(User $user): bool { return $user->hasPermissionTo('technical.sessions.view'); }
    public function create(User $user): bool { return $user->hasPermissionTo('technical.sessions.create'); }
    public function update(User $user, Session $model): bool { return $user->hasPermissionTo('technical.sessions.edit'); }
    public function delete(User $user, Session $model): bool { return $user->hasPermissionTo('technical.sessions.delete'); }
}
