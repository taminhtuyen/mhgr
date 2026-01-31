<?php

namespace App\Services\Logistics;

use App\Models\ShippingDriver;
use Illuminate\Support\Facades\Log;
use Exception;

class ShippingDriverService
{
    public function getPaginated($perPage = 10, $keyword = null)
    {
        $query = ShippingDriver::query();

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
            return ShippingDriver::create($data);
        } catch (Exception $e) {
            Log::error("Lỗi tạo ShippingDriver: " . $e->getMessage());
            return false;
        }
    }

    public function update(ShippingDriver $shippingDriver, array $data)
    {
        try {
            return $shippingDriver->update($data);
        } catch (Exception $e) {
            Log::error("Lỗi cập nhật ShippingDriver: " . $e->getMessage());
            return false;
        }
    }

    public function delete(ShippingDriver $shippingDriver)
    {
        try {
            return $shippingDriver->delete();
        } catch (Exception $e) {
            Log::error("Lỗi xóa ShippingDriver: " . $e->getMessage());
            return false;
        }
    }
}