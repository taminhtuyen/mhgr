<?php

namespace App\Services\Finance;

use App\Models\UserRewardWallet;

class RewardWalletService
{
    public function model()
    {
        return UserRewardWallet::class;
    }
}