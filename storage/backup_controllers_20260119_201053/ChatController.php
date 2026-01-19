<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class ChatController extends Controller {
    use HasTableSchema;
    public function index() {
        $tableName = 'chat_conversations';
        return view('admin.schema-view', ['title' => 'Hội Thoại Chat', 'table' => $tableName, 'columns' => $this->getSchema($tableName)]);
    }
}
