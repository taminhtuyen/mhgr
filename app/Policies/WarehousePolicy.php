<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Auth\Access\HandlesAuthorization;

class WarehousePolicy
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
     * Permission: inventory.warehouses.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('inventory.warehouses.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, Warehouse $model): bool
    {
        return $user->hasPermissionTo('inventory.warehouses.view');
    }

    /**
     * Quyền tạo mới
     * Permission: inventory.warehouses.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('inventory.warehouses.create');
    }

    /**
     * Quyền cập nhật
     * Permission: inventory.warehouses.edit
     */
    public function update(User $user, Warehouse $model): bool
    {
        return $user->hasPermissionTo('inventory.warehouses.edit');
    }

    /**
     * Quyền xóa
     * Permission: inventory.warehouses.delete
     */
    public function delete(User $user, Warehouse $model): bool
    {
        return $user->hasPermissionTo('inventory.warehouses.delete');
    }
}