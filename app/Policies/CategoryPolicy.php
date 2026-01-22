<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Category;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    /**
     * BỘ LỌC ADMIN (SUPER & STANDARD)
     * Hiện tại: Cả 2 loại admin đều có quyền tuyệt đối (bypass check).
     * Sau này: Nếu muốn cắt quyền admin_standard, chỉ cần xóa khỏi mảng bên dưới.
     */
    public function before(User $user, $ability)
    {
        if (in_array($user->user_type, ['admin_super', 'admin_standard'])) {
            return true;
        }
    }

    /**
     * Quyền xem danh sách
     * Permission: catalog.categories.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('catalog.categories.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, Category $model): bool
    {
        return $user->hasPermissionTo('catalog.categories.view');
    }

    /**
     * Quyền tạo mới
     * Permission: catalog.categories.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('catalog.categories.create');
    }

    /**
     * Quyền cập nhật
     * Permission: catalog.categories.edit
     */
    public function update(User $user, Category $model): bool
    {
        return $user->hasPermissionTo('catalog.categories.edit');
    }

    /**
     * Quyền xóa
     * Permission: catalog.categories.delete
     */
    public function delete(User $user, Category $model): bool
    {
        return $user->hasPermissionTo('catalog.categories.delete');
    }
}