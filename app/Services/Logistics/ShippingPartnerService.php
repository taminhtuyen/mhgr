<?php

namespace App\Services\Logistics;

use App\Models\ShippingPartner;
use Illuminate\Support\Facades\Log;
use Exception;

class ShippingPartnerService
{
    public function getPaginated($perPage = 10, $keyword = null)
    {
        $query = ShippingPartner::query();

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
            return ShippingPartner::create($data);
        } catch (Exception $e) {
            Log::error("Lỗi tạo ShippingPartner: " . $e->getMessage());
            return false;
        }
    }

    public function update(ShippingPartner $shippingPartner, array $data)
    {
        try {
            return $shippingPartner->update($data);
        } catch (Exception $e) {
            Log::error("Lỗi cập nhật ShippingPartner: " . $e->getMessage());
            return false;
        }
    }

    public function delete(ShippingPartner $shippingPartner)
    {
        try {
            return $shippingPartner->delete();
        } catch (Exception $e) {
            Log::error("Lỗi xóa ShippingPartner: " . $e->getMessage());
            return false;
        }
    }
}