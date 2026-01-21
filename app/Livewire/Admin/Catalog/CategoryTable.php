<?php

namespace App\Livewire\Admin\Catalog;

use Livewire\Component;
use App\Services\Catalog\CategoryService;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class CategoryTable extends Component
{
    protected $categoryService;

    public function boot(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function render()
    {
        // Lấy cây danh mục
        $categories = $this->categoryService->getTree();

        return view('livewire.admin.catalog.category-table', [
            'categories' => $categories
        ]);
    }

    public function deleteCategory($id)
    {
        try {
            $this->categoryService->deleteCategory($id);
            // Thông báo thành công (Dùng session flash hoặc dispatch browser event)
            $this->dispatch('alert', type: 'success', message: 'Đã xóa danh mục thành công!');
        } catch (\Exception $e) {
            $this->dispatch('alert', type: 'error', message: $e->getMessage());
        }
    }
}
