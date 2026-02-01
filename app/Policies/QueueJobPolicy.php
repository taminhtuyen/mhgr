<?php

namespace App\Policies;

use App\Models\User;
use App\Models\QueueJob;
use Illuminate\Auth\Access\HandlesAuthorization;

class QueueJobPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability) {
        if (in_array($user->user_type, ['admin_super', 'admin_standard'])) return true;
    }
    public function viewAny(User $user): bool { return $user->hasPermissionTo('technical.queue-jobs.view'); }
    public function create(User $user): bool { return $user->hasPermissionTo('technical.queue-jobs.create'); }
    public function update(User $user, QueueJob $model): bool { return $user->hasPermissionTo('technical.queue-jobs.edit'); }
    public function delete(User $user, QueueJob $model): bool { return $user->hasPermissionTo('technical.queue-jobs.delete'); }
}
