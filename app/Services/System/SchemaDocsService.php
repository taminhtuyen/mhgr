<?php

namespace App\Services\System;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SchemaDocsService
{
    /**
     * Định nghĩa Bảng Chính và Bảng Phụ cho từng Module
     */
    public static function getModuleMap()
    {
        return [
            // --- SALES ---
            'orders' => [
                'main' => 'orders',
                'related' => ['order_items', 'order_history', 'order_transactions', 'order_returns', 'deliveries', 'invoices', 'payments_transactions']
            ],
            'carts' => ['main' => 'carts', 'related' => ['cart_items']],
            'invoices' => ['main' => 'invoices', 'related' => ['orders', 'tax_rates']],
            'deliveries' => ['main' => 'deliveries', 'related' => ['orders', 'shipping_shipments']],
            'returns' => ['main' => 'order_returns', 'related' => ['orders', 'order_items']],

            // --- CATALOG ---
            'products' => [
                'main' => 'products',
                'related' => ['product_variations', 'product_attributes', 'product_tags', 'images', 'reviews', 'inventory_stocks']
            ],
            'categories' => ['main' => 'categories', 'related' => []],
            'attributes' => ['main' => 'attributes', 'related' => ['attribute_values', 'product_attributes']],
            'suppliers' => ['main' => 'suppliers', 'related' => ['purchase_orders']],
            'reviews' => ['main' => 'reviews', 'related' => ['products', 'users']],

            // --- INVENTORY ---
            'inventory-stocks' => ['main' => 'inventory_stocks', 'related' => ['warehouses', 'products']],
            'inventory-transactions' => ['main' => 'inventory_transactions', 'related' => ['orders', 'purchase_orders']],
            'warehouses' => ['main' => 'warehouses', 'related' => ['inventory_stocks']],
            'purchase-orders' => ['main' => 'purchase_orders', 'related' => ['purchase_order_items', 'suppliers']],

            // --- MARKETING ---
            'promotions' => ['main' => 'promotions', 'related' => ['promotion_usage']],
            'coupons' => ['main' => 'coupons', 'related' => []],
            'flash-sales' => ['main' => 'flash_sales', 'related' => ['flash_sale_products']],
            'affiliates' => ['main' => 'affiliates', 'related' => ['users']],

            // --- FINANCE ---
            'wallets' => ['main' => 'wallets', 'related' => ['wallet_transactions']],
            'commissions' => ['main' => 'commissions', 'related' => ['affiliates', 'orders']],
            'profit-distributions' => ['main' => 'profit_distributions', 'related' => []],

            // --- CONTENT ---
            'posts' => ['main' => 'posts', 'related' => ['categories', 'tags']],
            'banners' => ['main' => 'banners', 'related' => []],
            'pages' => ['main' => 'pages', 'related' => []],
            'menus' => ['main' => 'menus', 'related' => ['menu_items']],
            'images' => ['main' => 'images', 'related' => []],
            'game-subjects' => ['main' => 'game_subjects', 'related' => []],

            // --- CRM & CONSIGNMENT ---
            'customers' => ['main' => 'customers', 'related' => ['users']], // Map customer view to users table logic usually
            'chats' => ['main' => 'chats', 'related' => []],
            'requests' => ['main' => 'requests', 'related' => []],
            'consignments' => ['main' => 'consignments', 'related' => ['consignment_customers']],
            'consignment-customers' => ['main' => 'consignment_customers', 'related' => ['consignments']],

            // --- SYSTEM ---
            'users' => ['main' => 'users', 'related' => ['user_addresses', 'user_roles', 'wallets']],
            'roles' => ['main' => 'roles', 'related' => ['permissions', 'permissions_role']],
            'settings' => ['main' => 'settings', 'related' => []],
            'system-logs' => ['main' => 'system_logs', 'related' => []],
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
        if ($field === 'image' || $field === 'avatar') return 'Đường dẫn hình ảnh';
        if ($field === 'description') return 'Mô tả ngắn';
        if ($field === 'content') return 'Nội dung chi tiết';
        if ($field === 'price') return 'Giá bán';
        if ($field === 'sku') return 'Mã kho (Stock Keeping Unit)';
        if (str_contains($type, 'json')) return 'Dữ liệu cấu hình/mảng';
        if (str_contains($type, 'tinyint')) return 'Cờ bật/tắt (0/1)';

        return 'Dữ liệu thông thường';
    }
}