<?php

namespace App\Policies;

use App\Models\User;
use App\Models\LeaveSchedule;
use Illuminate\Auth\Access\HandlesAuthorization;

class LeaveSchedulePolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability) {
        if (in_array($user->user_type, ['admin_super', 'admin_standard'])) return true;
    }
    public function viewAny(User $user): bool { return $user->hasPermissionTo('system.leave-schedules.view'); }
    public function create(User $user): bool { return $user->hasPermissionTo('system.leave-schedules.create'); }
    public function update(User $user, LeaveSchedule $model): bool { return $user->hasPermissionTo('system.leave-schedules.edit'); }
    public function delete(User $user, LeaveSchedule $model): bool { return $user->hasPermissionTo('system.leave-schedules.delete'); }
}
