<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class GameSubjectController extends Controller {
    use HasTableSchema;
    public function index() {
        // Bảng chủ đề game/học tập
        $tableName = 'game_subjects';
        return view('admin.schema-view', ['title' => 'Chủ Đề Game/Học Tập', 'table' => $tableName, 'columns' => $this->getSchema($tableName)]);
    }
}
