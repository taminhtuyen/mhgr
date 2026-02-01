<?php
namespace App\Http\Controllers\Admin\System;
use App\Services\System\LeaveScheduleService;
use App\Http\Requests\Admin\System\LeaveScheduleRequest;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class LeaveScheduleController extends Controller {
    use HasTableSchema;
    public function index() {
        return view('admin.system.leave-schedules.index', [
            'title' => 'Danh Sách LeaveSchedule'
        ]);
    }
}
