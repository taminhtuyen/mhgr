<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TaxInvoice;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaxInvoicePolicy
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
     * Permission: sales.tax-invoices.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('sales.tax-invoices.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, TaxInvoice $model): bool
    {
        return $user->hasPermissionTo('sales.tax-invoices.view');
    }

    /**
     * Quyền tạo mới
     * Permission: sales.tax-invoices.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('sales.tax-invoices.create');
    }

    /**
     * Quyền cập nhật
     * Permission: sales.tax-invoices.edit
     */
    public function update(User $user, TaxInvoice $model): bool
    {
        return $user->hasPermissionTo('sales.tax-invoices.edit');
    }

    /**
     * Quyền xóa
     * Permission: sales.tax-invoices.delete
     */
    public function delete(User $user, TaxInvoice $model): bool
    {
        return $user->hasPermissionTo('sales.tax-invoices.delete');
    }
}