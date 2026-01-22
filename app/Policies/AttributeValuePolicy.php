<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AttributeValue;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttributeValuePolicy
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
     * Permission: general.attribute-values.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('general.attribute-values.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, AttributeValue $model): bool
    {
        return $user->hasPermissionTo('general.attribute-values.view');
    }

    /**
     * Quyền tạo mới
     * Permission: general.attribute-values.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('general.attribute-values.create');
    }

    /**
     * Quyền cập nhật
     * Permission: general.attribute-values.edit
     */
    public function update(User $user, AttributeValue $model): bool
    {
        return $user->hasPermissionTo('general.attribute-values.edit');
    }

    /**
     * Quyền xóa
     * Permission: general.attribute-values.delete
     */
    public function delete(User $user, AttributeValue $model): bool
    {
        return $user->hasPermissionTo('general.attribute-values.delete');
    }
}