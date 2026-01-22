<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
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
     * Permission: marketing.posts.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('marketing.posts.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, Post $model): bool
    {
        return $user->hasPermissionTo('marketing.posts.view');
    }

    /**
     * Quyền tạo mới
     * Permission: marketing.posts.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('marketing.posts.create');
    }

    /**
     * Quyền cập nhật
     * Permission: marketing.posts.edit
     */
    public function update(User $user, Post $model): bool
    {
        return $user->hasPermissionTo('marketing.posts.edit');
    }

    /**
     * Quyền xóa
     * Permission: marketing.posts.delete
     */
    public function delete(User $user, Post $model): bool
    {
        return $user->hasPermissionTo('marketing.posts.delete');
    }
}