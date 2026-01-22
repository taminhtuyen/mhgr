<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Product;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
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
     * Permission: catalog.products.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('catalog.products.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, Product $model): bool
    {
        return $user->hasPermissionTo('catalog.products.view');
    }

    /**
     * Quyền tạo mới
     * Permission: catalog.products.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('catalog.products.create');
    }

    /**
     * Quyền cập nhật
     * Permission: catalog.products.edit
     */
    public function update(User $user, Product $model): bool
    {
        return $user->hasPermissionTo('catalog.products.edit');
    }

    /**
     * Quyền xóa
     * Permission: catalog.products.delete
     */
    public function delete(User $user, Product $model): bool
    {
        return $user->hasPermissionTo('catalog.products.delete');
    }
}