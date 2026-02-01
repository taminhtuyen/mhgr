<?php
namespace App\Http\Controllers\Admin\Technical;
use App\Services\Technical\SessionService;
use App\Http\Requests\Admin\Technical\SessionRequest;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class SessionController extends Controller {
    use HasTableSchema;
    public function index() {
        return view('admin.technical.sessions.index', [
            'title' => 'Danh Sách Session'
        ]);
    }
}
