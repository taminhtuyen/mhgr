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

    /**
     * Dữ liệu gửi đi (Frontend sẽ nhận được biến data.notification)
     */
    public $notification;

    public function __construct($input)
    {
        // 1. Cấu hình mặc định
        $default = [
            'title'   => 'Thông báo', // iOS thường để tiêu đề ngắn gọn
            'content' => '',
            'type'    => 'info',
            'buttons' => []
        ];

        // 2. Chuẩn hóa dữ liệu đầu vào
        if (is_string($input)) {
            // TRƯỜNG HỢP 1: Chỉ truyền chuỗi văn bản
            // -> Tạo giao diện Alert iOS chuẩn: 1 nút "Đóng" màu Xanh, In đậm
            $default['content'] = $input;
            $default['buttons'][] = [
                'text'   => 'Đóng',
                'color'  => 'primary', // iOS dùng màu xanh (primary) cho nút OK
                'isBold' => true,      // iOS luôn in đậm nút hành động chính
                'action' => ['type' => 'dismiss']
            ];
        } elseif (is_array($input) || is_object($input)) {
            // TRƯỜNG HỢP 2: Truyền mảng cấu hình
            $data = (array) $input;

            // Gộp dữ liệu cơ bản
            $default = array_merge($default, array_diff_key($data, ['buttons' => []]));

            // Xử lý Buttons
            if (!empty($data['buttons']) && is_array($data['buttons'])) {
                // Nếu người dùng tự cấu hình nút -> Giữ nguyên
                $default['buttons'] = $data['buttons'];
            } elseif (empty($default['buttons'])) {
                // Nếu người dùng KHÔNG cấu hình nút -> Tạo nút mặc định kiểu iOS
                // Dù là lỗi hay thành công, nút "Đóng" đơn lẻ trên iOS vẫn thường là màu xanh chủ đạo
                $default['buttons'][] = [
                    'text'   => 'Đóng',
                    'color'  => 'primary',
                    'isBold' => true, // In đậm để người dùng dễ nhận biết nút bấm
                    'action' => ['type' => 'dismiss']
                ];
            }
        }

        $this->notification = $default;
    }

    public function broadcastOn()
    {
        return new Channel('notifications');
    }

    public function broadcastAs()
    {
        return 'system.message';
    }
}
