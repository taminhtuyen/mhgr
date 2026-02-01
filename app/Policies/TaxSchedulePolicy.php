<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TaxSchedule;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaxSchedulePolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability) {
        if (in_array($user->user_type, ['admin_super', 'admin_standard'])) return true;
    }
    public function viewAny(User $user): bool { return $user->hasPermissionTo('system.tax-schedules.view'); }
    public function create(User $user): bool { return $user->hasPermissionTo('system.tax-schedules.create'); }
    public function update(User $user, TaxSchedule $model): bool { return $user->hasPermissionTo('system.tax-schedules.edit'); }
    public function delete(User $user, TaxSchedule $model): bool { return $user->hasPermissionTo('system.tax-schedules.delete'); }
}
