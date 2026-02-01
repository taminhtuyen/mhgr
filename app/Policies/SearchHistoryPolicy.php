<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SearchHistory;
use Illuminate\Auth\Access\HandlesAuthorization;

class SearchHistoryPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability) {
        if (in_array($user->user_type, ['admin_super', 'admin_standard'])) return true;
    }
    public function viewAny(User $user): bool { return $user->hasPermissionTo('marketing.search-histories.view'); }
    public function create(User $user): bool { return $user->hasPermissionTo('marketing.search-histories.create'); }
    public function update(User $user, SearchHistory $model): bool { return $user->hasPermissionTo('marketing.search-histories.edit'); }
    public function delete(User $user, SearchHistory $model): bool { return $user->hasPermissionTo('marketing.search-histories.delete'); }
}
