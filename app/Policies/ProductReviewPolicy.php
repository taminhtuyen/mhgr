<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ProductReview;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductReviewPolicy
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
     * Permission: catalog.product-reviews.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('catalog.product-reviews.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, ProductReview $model): bool
    {
        return $user->hasPermissionTo('catalog.product-reviews.view');
    }

    /**
     * Quyền tạo mới
     * Permission: catalog.product-reviews.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('catalog.product-reviews.create');
    }

    /**
     * Quyền cập nhật
     * Permission: catalog.product-reviews.edit
     */
    public function update(User $user, ProductReview $model): bool
    {
        return $user->hasPermissionTo('catalog.product-reviews.edit');
    }

    /**
     * Quyền xóa
     * Permission: catalog.product-reviews.delete
     */
    public function delete(User $user, ProductReview $model): bool
    {
        return $user->hasPermissionTo('catalog.product-reviews.delete');
    }
}