<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Supplier;
use Illuminate\Auth\Access\HandlesAuthorization;

class SupplierPolicy
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
     * Permission: catalog.suppliers.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('catalog.suppliers.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, Supplier $model): bool
    {
        return $user->hasPermissionTo('catalog.suppliers.view');
    }

    /**
     * Quyền tạo mới
     * Permission: catalog.suppliers.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('catalog.suppliers.create');
    }

    /**
     * Quyền cập nhật
     * Permission: catalog.suppliers.edit
     */
    public function update(User $user, Supplier $model): bool
    {
        return $user->hasPermissionTo('catalog.suppliers.edit');
    }

    /**
     * Quyền xóa
     * Permission: catalog.suppliers.delete
     */
    public function delete(User $user, Supplier $model): bool
    {
        return $user->hasPermissionTo('catalog.suppliers.delete');
    }
}