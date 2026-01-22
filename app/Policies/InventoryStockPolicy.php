<?php

namespace App\Policies;

use App\Models\User;
use App\Models\InventoryStock;
use Illuminate\Auth\Access\HandlesAuthorization;

class InventoryStockPolicy
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
     * Permission: inventory.inventory-stocks.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('inventory.inventory-stocks.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, InventoryStock $model): bool
    {
        return $user->hasPermissionTo('inventory.inventory-stocks.view');
    }

    /**
     * Quyền tạo mới
     * Permission: inventory.inventory-stocks.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('inventory.inventory-stocks.create');
    }

    /**
     * Quyền cập nhật
     * Permission: inventory.inventory-stocks.edit
     */
    public function update(User $user, InventoryStock $model): bool
    {
        return $user->hasPermissionTo('inventory.inventory-stocks.edit');
    }

    /**
     * Quyền xóa
     * Permission: inventory.inventory-stocks.delete
     */
    public function delete(User $user, InventoryStock $model): bool
    {
        return $user->hasPermissionTo('inventory.inventory-stocks.delete');
    }
}