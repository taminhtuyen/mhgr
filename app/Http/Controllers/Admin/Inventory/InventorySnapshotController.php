<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use App\Services\Inventory\InventorySnapshotService;
use App\Http\Requests\Admin\Inventory\InventorySnapshotRequest;
use App\Models\InventorySnapshot;
use Illuminate\Http\Request;

class InventorySnapshotController extends Controller
{
    protected $inventorySnapshotService;

    public function __construct(InventorySnapshotService $service)
    {
        $this->inventorySnapshotService = $service;
    }

    public function index()
    {
        return view('admin.inventory.inventory-snapshots.index', [
            'title' => 'Quản lý InventorySnapshot'
        ]);
    }

    public function store(InventorySnapshotRequest $request)
    {
        $result = $this->inventorySnapshotService->create($request->validated());
        if($result) return redirect()->route('admin.inventory.inventory-snapshots.index')->with('success', 'Thêm mới thành công!');
        return back()->with('error', 'Lỗi khi thêm mới.');
    }

    public function update(InventorySnapshotRequest $request, InventorySnapshot $inventorySnapshot)
    {
        $result = $this->inventorySnapshotService->update($inventorySnapshot, $request->validated());
        if($result) return redirect()->route('admin.inventory.inventory-snapshots.index')->with('success', 'Cập nhật thành công!');
        return back()->with('error', 'Lỗi khi cập nhật.');
    }

    public function destroy(InventorySnapshot $inventorySnapshot)
    {
        $this->inventorySnapshotService->delete($inventorySnapshot);
        return redirect()->back()->with('success', 'Đã xóa dữ liệu.');
    }
}