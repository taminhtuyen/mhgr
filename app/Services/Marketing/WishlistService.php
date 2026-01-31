<?php

namespace App\Services\Marketing;

use App\Models\Wishlist;
use Illuminate\Support\Facades\Log;
use Exception;

class WishlistService
{
    public function getPaginated($perPage = 10, $keyword = null)
    {
        $query = Wishlist::query();

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
            return Wishlist::create($data);
        } catch (Exception $e) {
            Log::error("Lỗi tạo Wishlist: " . $e->getMessage());
            return false;
        }
    }

    public function update(Wishlist $wishlist, array $data)
    {
        try {
            return $wishlist->update($data);
        } catch (Exception $e) {
            Log::error("Lỗi cập nhật Wishlist: " . $e->getMessage());
            return false;
        }
    }

    public function delete(Wishlist $wishlist)
    {
        try {
            return $wishlist->delete();
        } catch (Exception $e) {
            Log::error("Lỗi xóa Wishlist: " . $e->getMessage());
            return false;
        }
    }
}