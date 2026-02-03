<?php

namespace App\Services\System;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SchemaDocsService
{
    /**
     * BẢN ĐỒ TOÀN DIỆN HỆ THỐNG
     */
    public static function getModuleMap()
    {
        return [
            // GROUP: SALES
            'orders' => ['title' => 'Quản lý đơn hàng', 'description' => 'Trung tâm xử lý đơn hàng.', 'main' => 'orders', 'related' => ['order_items', 'order_history', 'order_transactions', 'tax_invoices']],
            'carts' => ['title' => 'Giỏ hàng', 'description' => 'Giỏ hàng khách đang xem.', 'main' => 'carts', 'related' => ['cart_items']],
            'deliverys' => ['title' => 'Quản lý giao vận', 'description' => 'Theo dõi vận chuyển.', 'main' => 'shipping_shipments', 'related' => ['orders', 'shipping_drivers']],
            'shipping-shipments' => ['title' => 'Vận đơn chi tiết', 'description' => 'Chi tiết gói hàng.', 'main' => 'shipping_shipments', 'related' => ['orders']],
            'returns' => ['title' => 'Yêu cầu đổi trả', 'description' => 'Xử lý RMA.', 'main' => 'order_returns', 'related' => ['orders', 'order_items']],
            'tax-invoices' => ['title' => 'Hóa đơn đỏ (VAT)', 'description' => 'Quản lý xuất hóa đơn.', 'main' => 'tax_invoices', 'related' => ['orders']],

            // GROUP: CATALOG
            'products' => ['title' => 'Danh sách sản phẩm', 'description' => 'Quản lý thông tin sản phẩm.', 'main' => 'products', 'related' => ['product_variations', 'product_attributes', 'inventory_stocks']],
            'categorys' => ['title' => 'Danh mục sản phẩm', 'description' => 'Cây phân cấp danh mục.', 'main' => 'categories', 'related' => ['category_collections']],
            'categories' => ['title' => 'Danh mục sản phẩm', 'description' => 'Cây phân cấp danh mục.', 'main' => 'categories', 'related' => []],
            'category-collections' => ['title' => 'Bộ sưu tập', 'description' => 'Nhóm sản phẩm theo chủ đề.', 'main' => 'category_collections', 'related' => ['categories']],
            'attributes' => ['title' => 'Thuộc tính', 'description' => 'Size, Màu, Chất liệu...', 'main' => 'product_attributes', 'related' => ['attribute_values']],
            'suppliers' => ['title' => 'Nhà cung cấp', 'description' => 'Hồ sơ đối tác.', 'main' => 'suppliers', 'related' => ['import_orders']],
            'price-groups' => ['title' => 'Bảng giá', 'description' => 'Giá sỉ/lẻ/VIP.', 'main' => 'price_groups', 'related' => ['product_prices']],
            'product-reviews' => ['title' => 'Đánh giá', 'description' => 'Feedback khách hàng.', 'main' => 'product_reviews', 'related' => ['products']],

            // GROUP: INVENTORY
            'inventory-stocks' => ['title' => 'Tồn kho', 'description' => 'Số lượng hàng khả dụng.', 'main' => 'inventory_stocks', 'related' => ['warehouses', 'products']],
            'inventory-transactions' => ['title' => 'Nhật ký kho', 'description' => 'Lịch sử nhập/xuất.', 'main' => 'inventory_transactions', 'related' => ['orders', 'import_orders']],
            'import-orders' => ['title' => 'Đơn nhập hàng', 'description' => 'Purchase Orders.', 'main' => 'import_orders', 'related' => ['import_order_items']],
            'inventory-snapshots' => ['title' => 'Kiểm kê', 'description' => 'Đối soát tồn kho.', 'main' => 'inventory_snapshots', 'related' => ['inventory_stocks']],
            'packings' => ['title' => 'Quy cách đóng gói', 'description' => 'Thùng/Hộp.', 'main' => 'packings', 'related' => ['packing_details']],
            'warehouses' => ['title' => 'Kho hàng', 'description' => 'Địa điểm kho.', 'main' => 'warehouses', 'related' => ['inventory_stocks']],

            // GROUP: LOGISTICS
            'delivery-trips' => ['title' => 'Chuyến giao hàng', 'description' => 'Gom đơn đi giao.', 'main' => 'delivery_trips', 'related' => ['shipping_drivers']],
            'shipping-drivers' => ['title' => 'Tài xế', 'description' => 'Nhân viên giao hàng.', 'main' => 'shipping_drivers', 'related' => ['delivery_trips']],
            'shipping-partners' => ['title' => 'Đối tác vận chuyển', 'description' => 'GHTK, GHN...', 'main' => 'shipping_partners', 'related' => ['shipping_rates']],
            'shipping-rates' => ['title' => 'Cước phí', 'description' => 'Bảng giá vận chuyển.', 'main' => 'shipping_rates', 'related' => ['provinces']],
            'delivery-failures' => ['title' => 'Giao thất bại', 'description' => 'Xử lý hoàn kho.', 'main' => 'delivery_failures', 'related' => ['shipping_shipments']],

            // GROUP: MARKETING
            'promotions' => ['title' => 'Khuyến mãi', 'description' => 'Rule giảm giá.', 'main' => 'promotions', 'related' => ['promotion_rules']],
            'promotion-coupons' => ['title' => 'Coupon', 'description' => 'Mã giảm giá.', 'main' => 'promotion_coupons', 'related' => ['promotion_usage']],
            'flash-sales' => ['title' => 'Flash Sale', 'description' => 'Deal sốc.', 'main' => 'flash_sales', 'related' => ['flash_sale_products']],
            'affiliate-links' => ['title' => 'Affiliate', 'description' => 'Tiếp thị liên kết.', 'main' => 'affiliate_links', 'related' => ['affiliate_commissions']],
            'wishlists' => ['title' => 'Yêu thích', 'description' => 'Sản phẩm quan tâm.', 'main' => 'wishlists', 'related' => ['products']],
            'search-histories' => ['title' => 'Lịch sử tìm kiếm', 'description' => 'Từ khóa tìm kiếm.', 'main' => 'user_search_histories', 'related' => []],
            'promotion-logic-dictionaries' => ['title' => 'Từ điển Logic', 'description' => 'Điều kiện nâng cao.', 'main' => 'promotion_logic_dictionaries', 'related' => []],

            // GROUP: FINANCE
            'commissions' => ['title' => 'Hoa hồng', 'description' => 'Đối soát Affiliate.', 'main' => 'affiliate_commissions', 'related' => ['users', 'orders']],
            'reward-wallets' => ['title' => 'Ví điểm', 'description' => 'Điểm tích lũy.', 'main' => 'user_reward_wallets', 'related' => ['reward_histories']],
            'reward-histories' => ['title' => 'Lịch sử điểm', 'description' => 'Biến động điểm.', 'main' => 'reward_histories', 'related' => ['user_reward_wallets']],
            'profit-distribution-groups' => ['title' => 'Phân bổ lợi nhuận', 'description' => 'Chia sẻ lợi nhuận.', 'main' => 'profit_distribution_groups', 'related' => []],
            'payment-transactions' => ['title' => 'Giao dịch', 'description' => 'Log cổng thanh toán.', 'main' => 'payment_transactions', 'related' => ['orders']],
            'reward-rules' => ['title' => 'Quy tắc thưởng', 'description' => 'Cấu hình điểm thưởng.', 'main' => 'review_rating_rules', 'related' => []],
            'review-rating-rules' => ['title' => 'Quy tắc thưởng', 'description' => 'Cấu hình điểm thưởng.', 'main' => 'review_rating_rules', 'related' => []],

            // GROUP: CONTENT
            'news' => ['title' => 'Bản tin', 'description' => 'Tin tức hệ thống.', 'main' => 'news', 'related' => []],
            'posts' => ['title' => 'Bài viết', 'description' => 'Blog/Kiến thức.', 'main' => 'posts', 'related' => []],
            'banners' => ['title' => 'Banner', 'description' => 'Slider trang chủ.', 'main' => 'banners', 'related' => []],
            'menus' => ['title' => 'Menu', 'description' => 'Điều hướng.', 'main' => 'menus', 'related' => ['menu_items']],
            'contents' => ['title' => 'Khối tĩnh', 'description' => 'Nội dung cố định.', 'main' => 'contents', 'related' => []],
            'images' => ['title' => 'Thư viện ảnh', 'description' => 'Media.', 'main' => 'images', 'related' => []],
            'game-subjects' => ['title' => 'Chủ đề Game', 'description' => 'Gamification.', 'main' => 'game_subjects', 'related' => []],
            'game-languages' => ['title' => 'Ngôn ngữ Game', 'description' => 'Cấu hình Voice.', 'main' => 'game_languages', 'related' => []],

            // GROUP: CRM & SYSTEM
            'customers' => ['title' => 'Khách hàng', 'description' => 'Hồ sơ người dùng.', 'main' => 'users', 'related' => ['user_addresses']],
            'requests' => ['title' => 'Yêu cầu hỗ trợ', 'description' => 'Ticket.', 'main' => 'customer_requests', 'related' => ['users']],
            'membership-tiers' => ['title' => 'Hạng thành viên', 'description' => 'Cấp độ VIP.', 'main' => 'membership_tiers', 'related' => []],
            'chat-conversations' => ['title' => 'Hội thoại', 'description' => 'Chat Support.', 'main' => 'chat_conversations', 'related' => ['chat_messages']],
            'consignments' => ['title' => 'Đơn ký gửi', 'description' => 'Hàng ký gửi.', 'main' => 'consignments', 'related' => ['consignment_customers']],
            'consignment-customers' => ['title' => 'Khách ký gửi', 'description' => 'Đối tác.', 'main' => 'consignment_customers', 'related' => []],
            'users' => ['title' => 'Quản trị viên', 'description' => 'Nhân sự.', 'main' => 'users', 'related' => ['roles']],
            'roles' => ['title' => 'Phân quyền', 'description' => 'RBAC.', 'main' => 'roles', 'related' => ['permissions']],
            'settings' => ['title' => 'Cấu hình', 'description' => 'Cài đặt chung.', 'main' => 'settings', 'related' => []],
            'system-logs' => ['title' => 'System Log', 'description' => 'Nhật ký lỗi.', 'main' => 'system_logs', 'related' => []],
            'locations' => ['title' => 'Địa lý', 'description' => 'Tỉnh/Huyện.', 'main' => 'provinces', 'related' => ['wards']],
            'booking-statuses' => ['title' => 'Trạng thái Booking', 'description' => 'Status config.', 'main' => 'booking_statuses', 'related' => []],
            'leave-schedules' => ['title' => 'Lịch nghỉ', 'description' => 'Quản lý nhân sự.', 'main' => 'user_leave_schedules', 'related' => []],
            'tax-classes' => ['title' => 'Nhóm thuế', 'description' => 'Phân loại.', 'main' => 'tax_classes', 'related' => ['tax_rates']],
            'pulses' => ['title' => 'Pulse', 'description' => 'Sức khỏe server.', 'main' => 'pulse_entries', 'related' => []],
            'queue-jobs' => ['title' => 'Queue', 'description' => 'Background jobs.', 'main' => 'jobs', 'related' => ['failed_jobs']],
            'sessions' => ['title' => 'Sessions', 'description' => 'Phiên đăng nhập.', 'main' => 'sessions', 'related' => []],
            'dashboards' => ['title' => 'Dashboard', 'description' => 'Tổng quan.', 'main' => 'orders', 'related' => []],
        ];
    }

    /**
     * Lấy Schema chi tiết của bảng (Kèm Foreign Key thông minh)
     */
    public static function getTableDetails($tableName)
    {
        if (!Schema::hasTable($tableName)) return null;

        // 1. Lấy thông tin Foreign Keys CỨNG từ DB (nếu có)
        $dbForeignKeys = [];
        try {
            $dbName = DB::connection()->getDatabaseName();
            $rawFks = DB::select("
                SELECT COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME
                FROM information_schema.KEY_COLUMN_USAGE
                WHERE TABLE_SCHEMA = ?
                AND TABLE_NAME = ?
                AND REFERENCED_TABLE_NAME IS NOT NULL
            ", [$dbName, $tableName]);

            foreach ($rawFks as $fk) {
                $dbForeignKeys[$fk->COLUMN_NAME] = [
                    'table' => $fk->REFERENCED_TABLE_NAME,
                    'column' => $fk->REFERENCED_COLUMN_NAME
                ];
            }
        } catch (\Exception $e) {}

        // 2. Duyệt qua các cột để lấy thông tin và đoán FK
        $columns = [];
        $rawColumns = DB::select("SHOW FULL COLUMNS FROM `$tableName`");

        foreach ($rawColumns as $col) {
            $foreignKeyInfo = $dbForeignKeys[$col->Field] ?? null;

            if (!$foreignKeyInfo && str_ends_with($col->Field, '_id')) {
                $guessedTable = self::guessForeignTable($col->Field);
                if ($guessedTable) {
                    $foreignKeyInfo = [
                        'table' => $guessedTable,
                        'column' => 'id'
                    ];
                }
            }

            $columns[] = [
                'name' => $col->Field,
                'type' => $col->Type,
                'nullable' => $col->Null === 'YES' ? 'Yes' : 'No',
                'default' => $col->Default,
                'comment' => $col->Comment ?: self::guessPurpose($col->Field, $col->Type),
                'key' => $col->Key,
                'foreign_key' => $foreignKeyInfo
            ];
        }

        return [
            'name' => $tableName,
            'columns' => $columns
        ];
    }

    private static function guessForeignTable($columnName)
    {
        $baseName = str_replace('_id', '', $columnName);

        $customMap = [
            'shipping_province_id' => 'provinces',
            'billing_province_id'  => 'provinces',
            'province_id'          => 'provinces',
            'shipping_ward_id'     => 'wards',
            'billing_ward_id'      => 'wards',
            'ward_id'              => 'wards',
            'shipping_district_id' => 'districts',
            'billing_district_id'  => 'districts',
            'district_id'          => 'districts',
            'parent_id'            => null,
        ];

        if (array_key_exists($columnName, $customMap)) {
            if ($customMap[$columnName] && Schema::hasTable($customMap[$columnName])) {
                return $customMap[$columnName];
            }
            return null;
        }

        $pluralName = Str::plural($baseName);
        if (Schema::hasTable($pluralName)) {
            return $pluralName;
        }

        $userKeywords = [
            'manager', 'seller', 'buyer', 'creator', 'editor', 'author', 'user',
            'customer', 'reviewer', 'approver', 'admin', 'employee', 'staff', 'person'
        ];

        foreach ($userKeywords as $keyword) {
            if (str_contains($baseName, $keyword)) {
                if (Schema::hasTable('users')) {
                    return 'users';
                }
            }
        }

        if (Schema::hasTable($baseName)) {
            return $baseName;
        }

        return null;
    }

    private static function guessPurpose($field, $type)
    {
        if ($field === 'id') return 'Khóa chính (ID)';
        if (str_ends_with($field, '_id')) return 'Liên kết bảng khác';
        if ($field === 'created_at') return 'Ngày tạo';
        if ($field === 'updated_at') return 'Ngày cập nhật';
        if ($field === 'deleted_at') return 'Ngày xóa (Soft Delete)';
        if ($field === 'status') return 'Trạng thái';
        if ($field === 'is_active') return 'Kích hoạt?';
        if (str_contains($field, 'price') || str_contains($field, 'amount')) return 'Số tiền / Giá trị';
        if (str_contains($field, 'description')) return 'Mô tả';
        if (str_contains($field, 'content')) return 'Nội dung';
        if (str_contains($field, 'image')) return 'Hình ảnh';
        return 'Dữ liệu thông thường';
    }
}
