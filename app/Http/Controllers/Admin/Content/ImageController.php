<?php

namespace App\Http\Controllers\Admin\Content;
use App\Services\Content\ImageService;
use App\Http\Requests\Admin\Content\ImageRequest;

use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    use HasTableSchema;

    public function index()
    {
        return view('admin.content.images.index', [
            'title' => 'Thư viện hình ảnh (Media)'
        ]);
    }
}
