<?php
namespace App\Http\Controllers\Admin\Technical;
use App\Services\Technical\QueueJobService;
use App\Http\Requests\Admin\Technical\QueueJobRequest;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class QueueJobController extends Controller {
    use HasTableSchema;
    public function index() {
        return view('admin.technical.queue-jobs.index', [
            'title' => 'Danh Sách QueueJob'
        ]);
    }
}
