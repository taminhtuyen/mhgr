<?php

namespace App\Services\Sales;

use App\Models\OrderReturn;

class OrderReturnService
{
    public function model()
    {
        return OrderReturn::class;
    }
}