<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CategoryCollection;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryCollectionPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability) {
        if (in_array($user->user_type, ['admin_super', 'admin_standard'])) return true;
    }
    public function viewAny(User $user): bool { return $user->hasPermissionTo('catalog.category-collections.view'); }
    public function create(User $user): bool { return $user->hasPermissionTo('catalog.category-collections.create'); }
    public function update(User $user, CategoryCollection $model): bool { return $user->hasPermissionTo('catalog.category-collections.edit'); }
    public function delete(User $user, CategoryCollection $model): bool { return $user->hasPermissionTo('catalog.category-collections.delete'); }
}
