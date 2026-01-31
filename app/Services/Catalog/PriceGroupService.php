<?php

namespace App\Services\Catalog;

use App\Models\PriceGroup;
use Illuminate\Support\Facades\Log;
use Exception;

class PriceGroupService
{
    public function getPaginated($perPage = 10, $keyword = null)
    {
        $query = PriceGroup::query();

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
            return PriceGroup::create($data);
        } catch (Exception $e) {
            Log::error("Lỗi tạo PriceGroup: " . $e->getMessage());
            return false;
        }
    }

    public function update(PriceGroup $priceGroup, array $data)
    {
        try {
            return $priceGroup->update($data);
        } catch (Exception $e) {
            Log::error("Lỗi cập nhật PriceGroup: " . $e->getMessage());
            return false;
        }
    }

    public function delete(PriceGroup $priceGroup)
    {
        try {
            return $priceGroup->delete();
        } catch (Exception $e) {
            Log::error("Lỗi xóa PriceGroup: " . $e->getMessage());
            return false;
        }
    }
}