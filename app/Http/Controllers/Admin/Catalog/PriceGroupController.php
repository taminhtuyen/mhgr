<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\Http\Controllers\Controller;
use App\Services\Catalog\PriceGroupService;
use App\Http\Requests\Admin\Catalog\PriceGroupRequest;
use App\Models\PriceGroup;
use Illuminate\Http\Request;

class PriceGroupController extends Controller
{
    protected $priceGroupService;

    public function __construct(PriceGroupService $service)
    {
        $this->priceGroupService = $service;
    }

    public function index()
    {
        return view('admin.catalog.price-groups.index', [
            'title' => 'Quản lý PriceGroup'
        ]);
    }

    public function store(PriceGroupRequest $request)
    {
        $result = $this->priceGroupService->create($request->validated());
        if($result) return redirect()->route('admin.catalog.price-groups.index')->with('success', 'Thêm mới thành công!');
        return back()->with('error', 'Lỗi khi thêm mới.');
    }

    public function update(PriceGroupRequest $request, PriceGroup $priceGroup)
    {
        $result = $this->priceGroupService->update($priceGroup, $request->validated());
        if($result) return redirect()->route('admin.catalog.price-groups.index')->with('success', 'Cập nhật thành công!');
        return back()->with('error', 'Lỗi khi cập nhật.');
    }

    public function destroy(PriceGroup $priceGroup)
    {
        $this->priceGroupService->delete($priceGroup);
        return redirect()->back()->with('success', 'Đã xóa dữ liệu.');
    }
}