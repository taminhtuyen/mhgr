<?php

namespace App\Policies;

use App\Models\User;
use App\Models\News;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewsPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability) {
        if (in_array($user->user_type, ['admin_super', 'admin_standard'])) return true;
    }
    public function viewAny(User $user): bool { return $user->hasPermissionTo('content.news.view'); }
    public function create(User $user): bool { return $user->hasPermissionTo('content.news.create'); }
    public function update(User $user, News $model): bool { return $user->hasPermissionTo('content.news.edit'); }
    public function delete(User $user, News $model): bool { return $user->hasPermissionTo('content.news.delete'); }
}
