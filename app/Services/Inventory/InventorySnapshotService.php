<?php

namespace App\Services\Inventory;

use App\Models\InventorySnapshot;
use Illuminate\Support\Facades\Log;
use Exception;

class InventorySnapshotService
{
    public function getPaginated($perPage = 10, $keyword = null)
    {
        $query = InventorySnapshot::query();

        if (!empty($keyword)) {
            // Logic tìm kiếm cơ bản
            $query->where(function($q) use ($keyword) {
                // Kiểm tra nếu bảng có cột name hoặc code
                // $q->where('name', 'like', "%{$keyword}%")
                //   ->orWhere('code', 'like', "%{$keyword}%");
            });
        }

        return $query->latest()->paginate($perPage);
    }

    public function create(array $data)
    {
        try {
            return InventorySnapshot::create($data);
        } catch (Exception $e) {
            Log::error("Lỗi tạo InventorySnapshot: " . $e->getMessage());
            return false;
        }
    }

    public function update(InventorySnapshot $inventorySnapshot, array $data)
    {
        try {
            return $inventorySnapshot->update($data);
        } catch (Exception $e) {
            Log::error("Lỗi cập nhật InventorySnapshot: " . $e->getMessage());
            return false;
        }
    }

    public function delete(InventorySnapshot $inventorySnapshot)
    {
        try {
            return $inventorySnapshot->delete();
        } catch (Exception $e) {
            Log::error("Lỗi xóa InventorySnapshot: " . $e->getMessage());
            return false;
        }
    }
}