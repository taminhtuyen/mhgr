<?php

namespace App\Services\Logistics;

use App\Models\ShippingRate;
use Illuminate\Support\Facades\Log;
use Exception;

class ShippingRateService
{
    public function getPaginated($perPage = 10, $keyword = null)
    {
        $query = ShippingRate::query();

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
            return ShippingRate::create($data);
        } catch (Exception $e) {
            Log::error("Lỗi tạo ShippingRate: " . $e->getMessage());
            return false;
        }
    }

    public function update(ShippingRate $shippingRate, array $data)
    {
        try {
            return $shippingRate->update($data);
        } catch (Exception $e) {
            Log::error("Lỗi cập nhật ShippingRate: " . $e->getMessage());
            return false;
        }
    }

    public function delete(ShippingRate $shippingRate)
    {
        try {
            return $shippingRate->delete();
        } catch (Exception $e) {
            Log::error("Lỗi xóa ShippingRate: " . $e->getMessage());
            return false;
        }
    }
}