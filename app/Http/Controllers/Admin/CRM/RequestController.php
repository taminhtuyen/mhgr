<?php

namespace App\Http\Controllers\Admin\CRM;

use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    use HasTableSchema;

    public function index()
    {
        return view('admin.crm.requests.index', [
            'title' => 'Danh sách Yêu cầu & Góp ý'
        ]);
    }
}
