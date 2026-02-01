<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ReviewRatingRule;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReviewRatingRulePolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability) {
        if (in_array($user->user_type, ['admin_super', 'admin_standard'])) return true;
    }
    public function viewAny(User $user): bool { return $user->hasPermissionTo('finance.review-rating-rules.view'); }
    public function create(User $user): bool { return $user->hasPermissionTo('finance.review-rating-rules.create'); }
    public function update(User $user, ReviewRatingRule $model): bool { return $user->hasPermissionTo('finance.review-rating-rules.edit'); }
    public function delete(User $user, ReviewRatingRule $model): bool { return $user->hasPermissionTo('finance.review-rating-rules.delete'); }
}
