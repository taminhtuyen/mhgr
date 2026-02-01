<?php

namespace App\Policies;

use App\Models\User;
use App\Models\GameLanguage;
use Illuminate\Auth\Access\HandlesAuthorization;

class GameLanguagePolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability) {
        if (in_array($user->user_type, ['admin_super', 'admin_standard'])) return true;
    }
    public function viewAny(User $user): bool { return $user->hasPermissionTo('content.game-languages.view'); }
    public function create(User $user): bool { return $user->hasPermissionTo('content.game-languages.create'); }
    public function update(User $user, GameLanguage $model): bool { return $user->hasPermissionTo('content.game-languages.edit'); }
    public function delete(User $user, GameLanguage $model): bool { return $user->hasPermissionTo('content.game-languages.delete'); }
}
