<?php

use Illuminate\Support\Facades\Route;

// Route trang chủ User
Route::get('/', function () {
    return view('client.home.index');
});

// Bạn có thể thêm các route khác sau này
// Route::get('/admin', function() { return view('admin.dashboard'); });
