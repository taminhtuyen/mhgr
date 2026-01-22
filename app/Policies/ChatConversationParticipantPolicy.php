<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ChatConversationParticipant;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChatConversationParticipantPolicy
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
     * Permission: general.chat-conversation-participants.view
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('general.chat-conversation-participants.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User $user, ChatConversationParticipant $model): bool
    {
        return $user->hasPermissionTo('general.chat-conversation-participants.view');
    }

    /**
     * Quyền tạo mới
     * Permission: general.chat-conversation-participants.create
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('general.chat-conversation-participants.create');
    }

    /**
     * Quyền cập nhật
     * Permission: general.chat-conversation-participants.edit
     */
    public function update(User $user, ChatConversationParticipant $model): bool
    {
        return $user->hasPermissionTo('general.chat-conversation-participants.edit');
    }

    /**
     * Quyền xóa
     * Permission: general.chat-conversation-participants.delete
     */
    public function delete(User $user, ChatConversationParticipant $model): bool
    {
        return $user->hasPermissionTo('general.chat-conversation-participants.delete');
    }
}