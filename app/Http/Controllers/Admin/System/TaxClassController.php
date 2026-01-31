<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Services\System\TaxClassService;
use App\Http\Requests\Admin\System\TaxClassRequest;
use App\Models\TaxClass;
use Illuminate\Http\Request;

class TaxClassController extends Controller
{
    protected $taxClassService;

    public function __construct(TaxClassService $service)
    {
        $this->taxClassService = $service;
    }

    public function index()
    {
        return view('admin.system.tax-classes.index', [
            'title' => 'Quản lý TaxClass'
        ]);
    }

    public function store(TaxClassRequest $request)
    {
        $result = $this->taxClassService->create($request->validated());
        if($result) return redirect()->route('admin.system.tax-classes.index')->with('success', 'Thêm mới thành công!');
        return back()->with('error', 'Lỗi khi thêm mới.');
    }

    public function update(TaxClassRequest $request, TaxClass $taxClass)
    {
        $result = $this->taxClassService->update($taxClass, $request->validated());
        if($result) return redirect()->route('admin.system.tax-classes.index')->with('success', 'Cập nhật thành công!');
        return back()->with('error', 'Lỗi khi cập nhật.');
    }

    public function destroy(TaxClass $taxClass)
    {
        $this->taxClassService->delete($taxClass);
        return redirect()->back()->with('success', 'Đã xóa dữ liệu.');
    }
}