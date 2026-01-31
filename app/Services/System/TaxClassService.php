<?php

namespace App\Services\System;

use App\Models\TaxClass;
use Illuminate\Support\Facades\Log;
use Exception;

class TaxClassService
{
    public function getPaginated($perPage = 10, $keyword = null)
    {
        $query = TaxClass::query();

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
            return TaxClass::create($data);
        } catch (Exception $e) {
            Log::error("Lỗi tạo TaxClass: " . $e->getMessage());
            return false;
        }
    }

    public function update(TaxClass $taxClass, array $data)
    {
        try {
            return $taxClass->update($data);
        } catch (Exception $e) {
            Log::error("Lỗi cập nhật TaxClass: " . $e->getMessage());
            return false;
        }
    }

    public function delete(TaxClass $taxClass)
    {
        try {
            return $taxClass->delete();
        } catch (Exception $e) {
            Log::error("Lỗi xóa TaxClass: " . $e->getMessage());
            return false;
        }
    }
}