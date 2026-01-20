<?php
namespace App\Http\Controllers\Admin\CRM;
use App\Services\CRM\ChatConversationService;
use App\Http\Requests\Admin\CRM\ChatConversationRequest;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class ChatConversationController extends Controller {
    use HasTableSchema;
    public function index() {
        return view('admin.crm.chat-conversations.index', [
            'title' => 'Hội Thoại ChatConversation'
        ]);
    }
}
