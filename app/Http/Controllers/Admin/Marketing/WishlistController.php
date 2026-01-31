<?php

namespace App\Http\Controllers\Admin\Marketing;

use App\Http\Controllers\Controller;
use App\Services\Marketing\WishlistService;
use App\Http\Requests\Admin\Marketing\WishlistRequest;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    protected $wishlistService;

    public function __construct(WishlistService $service)
    {
        $this->wishlistService = $service;
    }

    public function index()
    {
        return view('admin.marketing.wishlists.index', [
            'title' => 'Quản lý Wishlist'
        ]);
    }

    public function store(WishlistRequest $request)
    {
        $result = $this->wishlistService->create($request->validated());
        if($result) return redirect()->route('admin.marketing.wishlists.index')->with('success', 'Thêm mới thành công!');
        return back()->with('error', 'Lỗi khi thêm mới.');
    }

    public function update(WishlistRequest $request, Wishlist $wishlist)
    {
        $result = $this->wishlistService->update($wishlist, $request->validated());
        if($result) return redirect()->route('admin.marketing.wishlists.index')->with('success', 'Cập nhật thành công!');
        return back()->with('error', 'Lỗi khi cập nhật.');
    }

    public function destroy(Wishlist $wishlist)
    {
        $this->wishlistService->delete($wishlist);
        return redirect()->back()->with('success', 'Đã xóa dữ liệu.');
    }
}