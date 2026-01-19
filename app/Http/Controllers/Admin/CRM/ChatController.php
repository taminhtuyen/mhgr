<?php
namespace App\Http\Controllers\Admin\CRM;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class ChatController extends Controller {
    use HasTableSchema;
    public function index() {
        return view('admin.crm.chats.index', [
            'title' => 'Hội Thoại Chat'
        ]);
    }
}
