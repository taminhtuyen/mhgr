<?php

namespace App\Services\Catalog;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Exception;

class CategoryService
{
    /**
     * Lấy toàn bộ danh mục theo dạng cây (Eager Loading children)
     * Chỉ lấy các danh mục gốc (parent_id = null), các con sẽ được load tự động
     */
    public function getTree()
    {
        return Category::with(['children' => function($query) {
            $query->orderBy('position', 'asc');
        }])
            ->whereNull('parent_id')
            ->orderBy('position', 'asc')
            ->get();
    }

    /**
     * Tạo danh mục mới
     */
    public function createCategory(array $data)
    {
        return DB::transaction(function () use ($data) {
            // 1. Tự động tạo slug nếu thiếu
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['name']);
            }

            // 2. Xử lý Parent, Level và Path
            $parent = null;
            if (!empty($data['parent_id'])) {
                $parent = Category::find($data['parent_id']);
            }

            if ($parent) {
                $data['level'] = $parent->level + 1;
                // Path tạm thời, sẽ update sau khi có ID
                $data['path'] = $parent->path;
            } else {
                $data['level'] = 0;
                $data['path'] = '';
                $data['parent_id'] = null; // Đảm bảo null nếu rỗng
            }

            // 3. Tạo Category
            $category = Category::create($data);

            // 4. Update Path chính xác: parent_path / current_id
            $newPath = $parent ? ($parent->path . '/' . $category->id) : (string)$category->id;
            $category->update(['path' => $newPath]);

            return $category;
        });
    }

    /**
     * Cập nhật danh mục
     */
    public function updateCategory($id, array $data)
    {
        $category = Category::findOrFail($id);

        return DB::transaction(function () use ($category, $data) {
            // Logic xử lý di chuyển nhánh cha con rất phức tạp (cập nhật lại toàn bộ path con cháu)
            // Ở phiên bản này ta tạm thời disable việc đổi parent_id nếu không cần thiết
            // Hoặc chỉ update các thông tin cơ bản.

            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['name']);
            }

            $category->update($data);
            return $category;
        });
    }

    /**
     * Xóa danh mục
     * Chỉ xóa được khi không có danh mục con
     */
    public function deleteCategory($id)
    {
        $category = Category::withCount('children')->findOrFail($id);

        if ($category->children_count > 0) {
            throw new Exception("Không thể xóa danh mục này vì còn chứa danh mục con.");
        }

        // Kiểm tra thêm: Có sản phẩm không? (Logic mở rộng sau này)
        // if ($category->products()->exists()) { ... }

        return $category->delete();
    }
}
