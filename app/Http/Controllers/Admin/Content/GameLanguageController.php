<?php
namespace App\Http\Controllers\Admin\Content;
use App\Services\Content\GameLanguageService;
use App\Http\Requests\Admin\Content\GameLanguageRequest;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class GameLanguageController extends Controller {
    use HasTableSchema;
    public function index() {
        return view('admin.content.game-languages.index', [
            'title' => 'Danh Sách GameLanguage'
        ]);
    }
}
