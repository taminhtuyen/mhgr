<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PromotionLogicDictionary;
use Illuminate\Auth\Access\HandlesAuthorization;

class PromotionLogicDictionaryPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability) {
        if (in_array($user->user_type, ['admin_super', 'admin_standard'])) return true;
    }
    public function viewAny(User $user): bool { return $user->hasPermissionTo('marketing.promotion-logic-dictionaries.view'); }
    public function create(User $user): bool { return $user->hasPermissionTo('marketing.promotion-logic-dictionaries.create'); }
    public function update(User $user, PromotionLogicDictionary $model): bool { return $user->hasPermissionTo('marketing.promotion-logic-dictionaries.edit'); }
    public function delete(User $user, PromotionLogicDictionary $model): bool { return $user->hasPermissionTo('marketing.promotion-logic-dictionaries.delete'); }
}
