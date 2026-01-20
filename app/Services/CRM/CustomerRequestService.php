<?php

namespace App\Services\CRM;

use App\Models\CustomerRequest;

class CustomerRequestService
{
    public function model()
    {
        return CustomerRequest::class;
    }
}