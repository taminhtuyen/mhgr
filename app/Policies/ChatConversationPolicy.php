<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ChatConversation;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChatConversationPolicy
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
     * Permission: crm.chat-conversations.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('crm.chat-conversations.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, ChatConversation $model): bool
    {
        return $user->hasPermissionTo('crm.chat-conversations.view');
    }

    /**
     * Quyền tạo mới
     * Permission: crm.chat-conversations.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('crm.chat-conversations.create');
    }

    /**
     * Quyền cập nhật
     * Permission: crm.chat-conversations.edit
     */
    public function update(User $user, ChatConversation $model): bool
    {
        return $user->hasPermissionTo('crm.chat-conversations.edit');
    }

    /**
     * Quyền xóa
     * Permission: crm.chat-conversations.delete
     */
    public function delete(User $user, ChatConversation $model): bool
    {
        return $user->hasPermissionTo('crm.chat-conversations.delete');
    }
}