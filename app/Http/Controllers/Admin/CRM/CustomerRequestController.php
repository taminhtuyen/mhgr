<?php

namespace App\Http\Controllers\Admin\CRM;
use App\Http\Requests\Admin\CRM\CustomerRequestRequest;

use App\Http\Controllers\Controller;
use App\Services\CRM\CustomerRequestService;
use Illuminate\Http\Request;

class CustomerRequestController extends Controller
{
    protected $service;

    public function __construct(CustomerRequestService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('admin.crm.requests.index');
    }
}