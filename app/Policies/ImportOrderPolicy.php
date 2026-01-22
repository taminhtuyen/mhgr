<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ImportOrder;
use Illuminate\Auth\Access\HandlesAuthorization;

class ImportOrderPolicy
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
     * Permission: inventory.import-orders.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('inventory.import-orders.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, ImportOrder $model): bool
    {
        return $user->hasPermissionTo('inventory.import-orders.view');
    }

    /**
     * Quyền tạo mới
     * Permission: inventory.import-orders.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('inventory.import-orders.create');
    }

    /**
     * Quyền cập nhật
     * Permission: inventory.import-orders.edit
     */
    public function update(User $user, ImportOrder $model): bool
    {
        return $user->hasPermissionTo('inventory.import-orders.edit');
    }

    /**
     * Quyền xóa
     * Permission: inventory.import-orders.delete
     */
    public function delete(User $user, ImportOrder $model): bool
    {
        return $user->hasPermissionTo('inventory.import-orders.delete');
    }
}