<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SystemNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    // Nhận nội dung thông báo từ nơi gọi
    public function __construct($message)
    {
        $this->message = $message;
    }

    // Tên kênh phát sóng (Channel): 'notifications'
    // Sau này VPS cũng sẽ dùng kênh này, không cần sửa.
    public function broadcastOn()
    {
        return new Channel('notifications');
    }

    // Tên sự kiện (Event Name): 'system.message'
    // Tên này dùng để JS bắt sự kiện.
    public function broadcastAs()
    {
        return 'system.message';
    }
}
