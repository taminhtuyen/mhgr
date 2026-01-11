<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    use HasTableSchema;

    public function index()
    {
        $tableName = 'requests';

        return view('admin.schema-view', [
            'title' => 'Danh sách Yêu cầu & Góp ý',
            'table' => $tableName,
            'columns' => $this->getSchema($tableName)
        ]);
    }
}
