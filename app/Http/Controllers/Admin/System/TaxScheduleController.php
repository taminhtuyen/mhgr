<?php
namespace App\Http\Controllers\Admin\System;
use App\Services\System\TaxScheduleService;
use App\Http\Requests\Admin\System\TaxScheduleRequest;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class TaxScheduleController extends Controller {
    use HasTableSchema;
    public function index() {
        return view('admin.system.tax-schedules.index', [
            'title' => 'Danh Sách TaxSchedule'
        ]);
    }
}
