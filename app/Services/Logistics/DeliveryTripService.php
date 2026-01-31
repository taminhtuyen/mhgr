<?php

namespace App\Services\Logistics;

use App\Models\DeliveryTrip;
use Illuminate\Support\Facades\Log;
use Exception;

class DeliveryTripService
{
    public function getPaginated($perPage = 10, $keyword = null)
    {
        $query = DeliveryTrip::query();

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
            return DeliveryTrip::create($data);
        } catch (Exception $e) {
            Log::error("Lỗi tạo DeliveryTrip: " . $e->getMessage());
            return false;
        }
    }

    public function update(DeliveryTrip $deliveryTrip, array $data)
    {
        try {
            return $deliveryTrip->update($data);
        } catch (Exception $e) {
            Log::error("Lỗi cập nhật DeliveryTrip: " . $e->getMessage());
            return false;
        }
    }

    public function delete(DeliveryTrip $deliveryTrip)
    {
        try {
            return $deliveryTrip->delete();
        } catch (Exception $e) {
            Log::error("Lỗi xóa DeliveryTrip: " . $e->getMessage());
            return false;
        }
    }
}