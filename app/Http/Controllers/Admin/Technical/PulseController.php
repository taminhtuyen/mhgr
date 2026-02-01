<?php
namespace App\Http\Controllers\Admin\Technical;
use App\Services\Technical\PulseService;
use App\Http\Requests\Admin\Technical\PulseRequest;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class PulseController extends Controller {
    use HasTableSchema;
    public function index() {
        return view('admin.technical.pulses.index', [
            'title' => 'Danh Sách Pulse'
        ]);
    }
}
