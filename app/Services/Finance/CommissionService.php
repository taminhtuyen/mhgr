<?php

namespace App\Services\Finance;

use App\Models\AffiliateCommission;

class CommissionService
{
    public function model()
    {
        return AffiliateCommission::class;
    }
}