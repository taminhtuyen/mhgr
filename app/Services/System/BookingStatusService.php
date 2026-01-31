<?php

namespace App\Services\System;

use App\Models\BookingStatus;
use Illuminate\Support\Facades\Log;
use Exception;

class BookingStatusService
{
    public function getPaginated($perPage = 10, $keyword = null)
    {
        $query = BookingStatus::query();

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
            return BookingStatus::create($data);
        } catch (Exception $e) {
            Log::error("Lỗi tạo BookingStatus: " . $e->getMessage());
            return false;
        }
    }

    public function update(BookingStatus $bookingStatus, array $data)
    {
        try {
            return $bookingStatus->update($data);
        } catch (Exception $e) {
            Log::error("Lỗi cập nhật BookingStatus: " . $e->getMessage());
            return false;
        }
    }

    public function delete(BookingStatus $bookingStatus)
    {
        try {
            return $bookingStatus->delete();
        } catch (Exception $e) {
            Log::error("Lỗi xóa BookingStatus: " . $e->getMessage());
            return false;
        }
    }
}