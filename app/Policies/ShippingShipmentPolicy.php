<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ShippingShipment;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShippingShipmentPolicy
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
     * Permission: sales.shipping-shipments.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('sales.shipping-shipments.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, ShippingShipment $model): bool
    {
        return $user->hasPermissionTo('sales.shipping-shipments.view');
    }

    /**
     * Quyền tạo mới
     * Permission: sales.shipping-shipments.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('sales.shipping-shipments.create');
    }

    /**
     * Quyền cập nhật
     * Permission: sales.shipping-shipments.edit
     */
    public function update(User $user, ShippingShipment $model): bool
    {
        return $user->hasPermissionTo('sales.shipping-shipments.edit');
    }

    /**
     * Quyền xóa
     * Permission: sales.shipping-shipments.delete
     */
    public function delete(User $user, ShippingShipment $model): bool
    {
        return $user->hasPermissionTo('sales.shipping-shipments.delete');
    }
}