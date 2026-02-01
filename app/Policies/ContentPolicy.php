<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Content;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContentPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability) {
        if (in_array($user->user_type, ['admin_super', 'admin_standard'])) return true;
    }
    public function viewAny(User $user): bool { return $user->hasPermissionTo('content.contents.view'); }
    public function create(User $user): bool { return $user->hasPermissionTo('content.contents.create'); }
    public function update(User $user, Content $model): bool { return $user->hasPermissionTo('content.contents.edit'); }
    public function delete(User $user, Content $model): bool { return $user->hasPermissionTo('content.contents.delete'); }
}
