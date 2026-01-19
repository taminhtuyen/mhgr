<?php

namespace App\Services\System;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SchemaDocsService
{
    /**
     * Định nghĩa Bảng Chính và Bảng Phụ cho từng Module
     * Key của mảng này phải trùng với tên Resource trên URL (Route)
     */
    public static function getModuleMap()
    {
        return [
            // --- SALES (BÁN HÀNG) ---
            'orders' => [
                'main' => 'orders',
                'related' => ['order_items', 'order_history', 'order_transactions', 'order_returns', 'shipping_shipments', 'tax_invoices', 'payment_transactions']
            ],
            'carts' => ['main' => 'carts', 'related' => ['cart_items']],
            // [CẬP NHẬT] invoices -> tax-invoices
            'tax-invoices' => ['main' => 'tax_invoices', 'related' => ['orders', 'tax_rates']],
            // [CẬP NHẬT] deliveries -> shipping-shipments
            'shipping-shipments' => ['main' => 'shipping_shipments', 'related' => ['orders']],
            'returns' => ['main' => 'order_returns', 'related' => ['orders', 'order_items']],

            // --- CATALOG (SẢN PHẨM) ---
            'products' => [
                'main' => 'products',
                'related' => ['product_variations', 'product_attributes', 'product_tags', 'images', 'product_reviews', 'inventory_stocks']
            ],
            'categories' => ['main' => 'categories', 'related' => []],
            'attributes' => ['main' => 'product_attributes', 'related' => ['attribute_values']],
            'suppliers' => ['main' => 'suppliers', 'related' => ['import_orders']],
            // [CẬP NHẬT] reviews -> product-reviews
            'product-reviews' => ['main' => 'product_reviews', 'related' => ['products', 'users']],

            // --- INVENTORY (KHO HÀNG) ---
            // [CẬP NHẬT] inventory-stocks -> stocks (theo route mới)
            'stocks' => ['main' => 'inventory_stocks', 'related' => ['warehouses', 'products']],
            // [CẬP NHẬT] inventory-transactions -> transactions
            'transactions' => ['main' => 'inventory_transactions', 'related' => ['orders', 'import_orders']],
            'warehouses' => ['main' => 'warehouses', 'related' => ['inventory_stocks']],
            // [CẬP NHẬT] purchase-orders -> import-orders
            'import-orders' => ['main' => 'import_orders', 'related' => ['import_order_items', 'suppliers']],

            // --- MARKETING ---
            'promotions' => ['main' => 'promotions', 'related' => ['promotion_usage']],
            // [CẬP NHẬT] coupons -> promotion-coupons
            'promotion-coupons' => ['main' => 'promotion_coupons', 'related' => []],
            'flash-sales' => ['main' => 'flash_sales', 'related' => ['flash_sale_products']],
            // [CẬP NHẬT] affiliates -> affiliate-links
            'affiliate-links' => ['main' => 'affiliate_links', 'related' => ['users']],

            // --- FINANCE (TÀI CHÍNH) ---
            // [CẬP NHẬT] wallets -> reward-wallets
            'reward-wallets' => ['main' => 'users_reward_wallets', 'related' => ['users_reward_history']],
            'commissions' => ['main' => 'affiliate_commissions', 'related' => ['affiliate_links', 'orders']],
            // [CẬP NHẬT] profit-distributions -> profit-distribution-groups
            'profit-distribution-groups' => ['main' => 'profit_distribution_groups', 'related' => []],

            // --- CONTENT (NỘI DUNG) ---
            'posts' => ['main' => 'posts', 'related' => ['categories']],
            'banners' => ['main' => 'banners', 'related' => []],
            'menus' => ['main' => 'menus', 'related' => ['menu_items']],
            'images' => ['main' => 'images', 'related' => []],
            'game-subjects' => ['main' => 'game_subjects', 'related' => []],

            // --- CRM & CONSIGNMENT ---
            'customers' => ['main' => 'users', 'related' => ['user_addresses']], // CRM Customers
            // [CẬP NHẬT] chats -> chat-conversations
            'chat-conversations' => ['main' => 'chat_conversations', 'related' => ['chat_messages', 'chat_participants']],
            'requests' => ['main' => 'support_requests', 'related' => []],
            'consignments' => ['main' => 'consignment_orders', 'related' => ['consignment_customers']],

            // Lưu ý: Nếu URL admin/consignment/customers trùng với admin/crm/customers, key này có thể bị conflict.
            // Tạm thời map vào consignment_customers
            'consignment-customers' => ['main' => 'consignment_customers', 'related' => ['consignment_orders']],

            // --- SYSTEM ---
            'users' => ['main' => 'users', 'related' => ['user_addresses', 'user_roles', 'users_reward_wallets']],
            'roles' => ['main' => 'roles', 'related' => ['permissions', 'permissions_role']],
            'settings' => ['main' => 'settings', 'related' => []],
            // [CẬP NHẬT] system-logs -> logs
            'logs' => ['main' => 'system_logs', 'related' => []],
            'locations' => ['main' => 'provinces', 'related' => ['wards']],
        ];
    }

    public static function getTableDetails($tableName)
    {
        if (!Schema::hasTable($tableName)) return null;

        $columns = [];
        // Lấy thông tin chi tiết cột (Type, Nullable, Default, Comment)
        $rawColumns = DB::select("SHOW FULL COLUMNS FROM `$tableName`");

        foreach ($rawColumns as $col) {
            $columns[] = [
                'name' => $col->Field,
                'type' => $col->Type,
                'null' => $col->Null === 'YES' ? 'Có' : 'Không',
                'default' => $col->Default,
                'comment' => $col->Comment ?: self::guessPurpose($col->Field, $col->Type),
                'key' => $col->Key
            ];
        }

        return [
            'name' => $tableName,
            'columns' => $columns
        ];
    }

    private static function guessPurpose($field, $type)
    {
        if ($field === 'id') return 'Khóa chính (Primary Key)';
        if (str_ends_with($field, '_id')) return 'Khóa ngoại (Liên kết bảng khác)';
        if ($field === 'created_at') return 'Thời gian tạo';
        if ($field === 'updated_at') return 'Thời gian cập nhật cuối';
        if ($field === 'deleted_at') return 'Thời gian xóa mềm (Soft Delete)';
        if ($field === 'status') return 'Trạng thái hoạt động';
        if ($field === 'name' || $field === 'title') return 'Tên định danh';
        if ($field === 'slug') return 'Đường dẫn URL thân thiện (SEO)';
        if ($field === 'image' || $field === 'avatar' || $field === 'proof_image') return 'Đường dẫn hình ảnh';
        if ($field === 'description') return 'Mô tả ngắn';
        if ($field === 'content') return 'Nội dung chi tiết';
        if ($field === 'price' || $field === 'total_cost' || str_contains($field, 'amount') || str_contains($field, 'fee')) return 'Số tiền / Giá trị';
        if ($field === 'sku') return 'Mã kho (Stock Keeping Unit)';
        if ($field === 'tracking_code') return 'Mã vận đơn';
        if (str_contains($type, 'json')) return 'Dữ liệu cấu hình/mảng';
        if (str_contains($type, 'tinyint')) return 'Cờ bật/tắt (0/1)';
        if (str_contains($type, 'date') || str_contains($type, 'time')) return 'Ngày giờ';

        return 'Dữ liệu thông thường';
    }
}
