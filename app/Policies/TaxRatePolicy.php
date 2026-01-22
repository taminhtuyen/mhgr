<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TaxRate;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaxRatePolicy
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
     * Permission: general.tax-rates.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('general.tax-rates.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, TaxRate $model): bool
    {
        return $user->hasPermissionTo('general.tax-rates.view');
    }

    /**
     * Quyền tạo mới
     * Permission: general.tax-rates.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('general.tax-rates.create');
    }

    /**
     * Quyền cập nhật
     * Permission: general.tax-rates.edit
     */
    public function update(User $user, TaxRate $model): bool
    {
        return $user->hasPermissionTo('general.tax-rates.edit');
    }

    /**
     * Quyền xóa
     * Permission: general.tax-rates.delete
     */
    public function delete(User $user, TaxRate $model): bool
    {
        return $user->hasPermissionTo('general.tax-rates.delete');
    }
}