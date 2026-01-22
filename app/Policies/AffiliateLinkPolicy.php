<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AffiliateLink;
use Illuminate\Auth\Access\HandlesAuthorization;

class AffiliateLinkPolicy
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
     * Permission: marketing.affiliate-links.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('marketing.affiliate-links.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, AffiliateLink $model): bool
    {
        return $user->hasPermissionTo('marketing.affiliate-links.view');
    }

    /**
     * Quyền tạo mới
     * Permission: marketing.affiliate-links.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('marketing.affiliate-links.create');
    }

    /**
     * Quyền cập nhật
     * Permission: marketing.affiliate-links.edit
     */
    public function update(User $user, AffiliateLink $model): bool
    {
        return $user->hasPermissionTo('marketing.affiliate-links.edit');
    }

    /**
     * Quyền xóa
     * Permission: marketing.affiliate-links.delete
     */
    public function delete(User $user, AffiliateLink $model): bool
    {
        return $user->hasPermissionTo('marketing.affiliate-links.delete');
    }
}