<?php
namespace App\Http\Controllers\Admin\Content;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class GameSubjectController extends Controller {
    use HasTableSchema;
    public function index() {
        // Bảng chủ đề game/học tập
        return view('admin.content.game-subjects.index', [
            'title' => 'Chủ Đề Game/Học Tập'
        ]);
    }
}
