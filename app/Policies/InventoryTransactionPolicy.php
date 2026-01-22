<?php

namespace App\Policies;

use App\Models\User;
use App\Models\InventoryTransaction;
use Illuminate\Auth\Access\HandlesAuthorization;

class InventoryTransactionPolicy
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
     * Permission: inventory.inventory-transactions.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('inventory.inventory-transactions.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, InventoryTransaction $model): bool
    {
        return $user->hasPermissionTo('inventory.inventory-transactions.view');
    }

    /**
     * Quyền tạo mới
     * Permission: inventory.inventory-transactions.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('inventory.inventory-transactions.create');
    }

    /**
     * Quyền cập nhật
     * Permission: inventory.inventory-transactions.edit
     */
    public function update(User $user, InventoryTransaction $model): bool
    {
        return $user->hasPermissionTo('inventory.inventory-transactions.edit');
    }

    /**
     * Quyền xóa
     * Permission: inventory.inventory-transactions.delete
     */
    public function delete(User $user, InventoryTransaction $model): bool
    {
        return $user->hasPermissionTo('inventory.inventory-transactions.delete');
    }
}