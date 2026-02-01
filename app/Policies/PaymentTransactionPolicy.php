<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PaymentTransaction;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaymentTransactionPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability) {
        if (in_array($user->user_type, ['admin_super', 'admin_standard'])) return true;
    }
    public function viewAny(User $user): bool { return $user->hasPermissionTo('finance.payment-transactions.view'); }
    public function create(User $user): bool { return $user->hasPermissionTo('finance.payment-transactions.create'); }
    public function update(User $user, PaymentTransaction $model): bool { return $user->hasPermissionTo('finance.payment-transactions.edit'); }
    public function delete(User $user, PaymentTransaction $model): bool { return $user->hasPermissionTo('finance.payment-transactions.delete'); }
}
