<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ChatConversationMessage;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChatConversationMessagePolicy
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
     * Permission: general.chat-conversation-messages.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('general.chat-conversation-messages.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, ChatConversationMessage $model): bool
    {
        return $user->hasPermissionTo('general.chat-conversation-messages.view');
    }

    /**
     * Quyền tạo mới
     * Permission: general.chat-conversation-messages.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('general.chat-conversation-messages.create');
    }

    /**
     * Quyền cập nhật
     * Permission: general.chat-conversation-messages.edit
     */
    public function update(User $user, ChatConversationMessage $model): bool
    {
        return $user->hasPermissionTo('general.chat-conversation-messages.edit');
    }

    /**
     * Quyền xóa
     * Permission: general.chat-conversation-messages.delete
     */
    public function delete(User $user, ChatConversationMessage $model): bool
    {
        return $user->hasPermissionTo('general.chat-conversation-messages.delete');
    }
}