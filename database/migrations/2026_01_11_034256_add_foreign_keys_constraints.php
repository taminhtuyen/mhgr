<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ----------------------------------------------------------------
        // 1. NHÓM USERS & ROLES
        // ----------------------------------------------------------------
        Schema::table('wards', function (Blueprint $table) {
            $table->foreign('province_id')->references('id')->on('provinces')->onDelete('cascade');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('user_roles', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
        Schema::table('permissions_role', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
        });
        Schema::table('user_addresses', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('ward_id')->references('id')->on('wards')->onDelete('cascade');
        });
        Schema::table('users_admin_profiles', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('users_customer_profiles', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('user_leave_schedules', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('user_profit_percentage_history', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('review_rating_rules_id')->references('id')->on('review_rating_rules')->onDelete('set null');
        });
        Schema::table('users_reward_wallets', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('users_reward_history', function (Blueprint $table) {
            $table->foreign('wallet_id')->references('id')->on('users_reward_wallets')->onDelete('cascade');
        });
        Schema::table('users_social_accounts', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('user_permissions', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
        });
        Schema::table('user_region', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('region_id')->references('id')->on('wards')->onDelete('cascade');
        });
        Schema::table('permissions', function (Blueprint $table) {
            $table->foreign('role_group_id')->references('id')->on('roles')->onDelete('set null');
        });

        // ----------------------------------------------------------------
        // 2. NHÓM SẢN PHẨM (PRODUCTS)
        // ----------------------------------------------------------------
        Schema::table('categories', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('tax_class_id')->references('id')->on('tax_classes')->onDelete('set null');
        });
        Schema::table('category_attributes', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('attribute_id')->references('id')->on('product_attributes')->onDelete('cascade');
        });
        Schema::table('category_collection_product', function (Blueprint $table) {
            $table->foreign('collection_id')->references('id')->on('category_collections')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('original_product_id')->references('id')->on('products')->onDelete('set null');
        });
        Schema::table('product_variations', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('original_variation_id')->references('id')->on('product_variations')->onDelete('set null');
        });
        Schema::table('product_prices', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('price_group_id')->references('id')->on('price_groups')->onDelete('cascade');
            $table->foreign('product_variation_id')->references('id')->on('product_variations')->onDelete('cascade');
        });
        Schema::table('product_attributes_values', function (Blueprint $table) {
            $table->foreign('product_attribute_id')->references('id')->on('product_attributes')->onDelete('cascade');
        });
        Schema::table('product_variation_attribute_values', function (Blueprint $table) {
            $table->foreign('variation_id')->references('id')->on('product_variations')->onDelete('cascade');
            $table->foreign('attribute_value_id')->references('id')->on('product_attributes_values')->onDelete('cascade');
        });
        Schema::table('product_region', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('region_id')->references('id')->on('wards')->onDelete('cascade');
        });
        Schema::table('product_user', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('product_sourcing', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
        });
        Schema::table('product_reviews', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
        });

        // ----------------------------------------------------------------
        // 3. NHÓM KHO VẬN (INVENTORY)
        // ----------------------------------------------------------------

        // Cập nhật FK địa chỉ cho bảng warehouses chính thức
        Schema::table('warehouses', function (Blueprint $table) {
            $table->foreign('ward_id')->references('id')->on('wards');
            $table->foreign('province_id')->references('id')->on('provinces');
        });

        Schema::table('inventory_stocks', function (Blueprint $table) {
            // warehouse_id trỏ về bảng warehouses (đã hợp nhất)
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('product_variation_id')->references('id')->on('product_variations')->onDelete('cascade');
        });

        Schema::table('inventory_transactions', function (Blueprint $table) {
            // warehouse_id trỏ về bảng warehouses
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->index(['reference_id', 'type']);
        });

        // [KHÔI PHỤC] Bảng Snapshots - Lưu ý trỏ warehouse_id về bảng 'warehouses'
        Schema::table('inventory_snapshots', function (Blueprint $table) {
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('product_variation_id')->references('id')->on('product_variations')->onDelete('cascade');
            // Thêm index để truy vấn báo cáo nhanh hơn
            $table->index(['recorded_date']);
            $table->index(['product_id', 'warehouse_id']);
        });

        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->foreign('warehouse_id')->references('id')->on('warehouses');
            $table->foreign('creator_id')->references('id')->on('users');
        });

        Schema::table('purchase_order_items', function (Blueprint $table) {
            $table->foreign('purchase_order_id')->references('id')->on('purchase_orders')->onDelete('cascade');
        });

        // ----------------------------------------------------------------
        // 4. NHÓM CART & PROMOTIONS
        // ----------------------------------------------------------------
        Schema::table('carts', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('cart_items', function (Blueprint $table) {
            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
        Schema::table('promotion_rules', function (Blueprint $table) {
            $table->foreign('promotion_id')->references('id')->on('promotions')->onDelete('cascade');
        });
        Schema::table('promotion_coupons', function (Blueprint $table) {
            $table->foreign('promotion_id')->references('id')->on('promotions')->onDelete('cascade');
            $table->foreign('promotion_rule_id')->references('id')->on('promotion_rules')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
        Schema::table('promotion_rule_products', function (Blueprint $table) {
            $table->foreign('promotion_rule_id')->references('id')->on('promotion_rules')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
        Schema::table('promotion_inventory', function (Blueprint $table) {
            $table->foreign('promotion_id')->references('id')->on('promotions')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
        Schema::table('promotion_customer_usage', function (Blueprint $table) {
            $table->index(['customer_id', 'promotion_id']);
            $table->index('order_id');
        });
        Schema::table('flash_sale_items', function (Blueprint $table) {
            $table->foreign('flash_sale_id')->references('id')->on('flash_sales')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('product_variation_id')->references('id')->on('product_variations')->onDelete('cascade');
        });

        // ----------------------------------------------------------------
        // 5. NHÓM AFFILIATE, CHAT & GAME
        // ----------------------------------------------------------------
        Schema::table('affiliate_links', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('affiliate_commissions', function (Blueprint $table) {
            $table->foreign('affiliate_user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('chat_messages', function (Blueprint $table) {
            $table->foreign('conversation_id')->references('id')->on('chat_conversations')->onDelete('cascade');
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('chat_participants', function (Blueprint $table) {
            $table->foreign('conversation_id')->references('id')->on('chat_conversations')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('game_voices', function (Blueprint $table) {
            $table->foreign('language_id')->references('id')->on('game_languages')->onDelete('cascade');
        });
        Schema::table('game_audio_files', function (Blueprint $table) {
            $table->foreign('subject_id')->references('id')->on('game_subjects')->onDelete('cascade');
            $table->foreign('voice_id')->references('id')->on('game_voices')->onDelete('cascade');
        });

        // ----------------------------------------------------------------
        // 6. NHÓM VẬN CHUYỂN (SHIPPING)
        // ----------------------------------------------------------------
        Schema::table('shipping_drivers', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('shipping_partner_id')->references('id')->on('shipping_partners');
        });
        Schema::table('shipping_shipments', function (Blueprint $table) {
            $table->foreign('driver_id')->references('id')->on('shipping_drivers');
            $table->foreign('shipping_partner_id')->references('id')->on('shipping_partners');
            $table->foreign('warehouse_id')->references('id')->on('warehouses'); // Trỏ về warehouses
        });
        Schema::table('shipping_shipment_items', function (Blueprint $table) {
            $table->foreign('shipment_id')->references('id')->on('shipping_shipments')->onDelete('cascade');
        });
        Schema::table('shipping_rates', function (Blueprint $table) {
            $table->foreign('province_id')->references('id')->on('provinces')->onDelete('cascade');
        });
        Schema::table('shipping_manager_reviews', function (Blueprint $table) {
            $table->foreign('shipping_manager_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('delivery_attempts', function (Blueprint $table) {
            $table->index('order_id');
        });

        // ----------------------------------------------------------------
        // 7. NHÓM MEDIA & CMS
        // ----------------------------------------------------------------
        Schema::table('imageables', function (Blueprint $table) {
            $table->foreign('image_id')->references('id')->on('images')->onDelete('cascade');
            $table->index(['imageable_id', 'imageable_type']);
        });
        Schema::table('product_images', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
        Schema::table('product_variation_images', function (Blueprint $table) {
            $table->foreign('product_variation_id')->references('id')->on('product_variations')->onDelete('cascade');
            $table->foreign('image_id')->references('id')->on('images')->onDelete('cascade');
        });
        Schema::table('product_variation_images_pivot', function (Blueprint $table) {
            $table->foreign('product_variation_id')->references('id')->on('product_variations')->onDelete('cascade');
            $table->foreign('product_image_id')->references('id')->on('product_images')->onDelete('cascade');
        });
        Schema::table('product_videos', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
        Schema::table('news', function (Blueprint $table) {
            $table->foreign('author_id')->references('id')->on('users')->onDelete('set null');
        });
        Schema::table('menu_items', function (Blueprint $table) {
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
        });

        // ----------------------------------------------------------------
        // 8. NHÓM CONSIGNMENT & BOOKING
        // ----------------------------------------------------------------
        Schema::table('booking_profit', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
            $table->index('order_id');
        });
        Schema::table('booking_status_transitions', function (Blueprint $table) {
            $table->foreign('from_status_code')->references('delivery_progress_code')->on('booking_status')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('to_status_code')->references('delivery_progress_code')->on('booking_status')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('permission_code_required')->references('code')->on('permissions')->onDelete('cascade')->onUpdate('cascade');
        });
        Schema::table('consignment_order_items', function (Blueprint $table) {
            $table->foreign('consignment_id')->references('id')->on('consignment_orders')->onDelete('cascade')->onUpdate('cascade');
            $table->index('product_id');
        });

        // ----------------------------------------------------------------
        // 9. NHÓM LỢI NHUẬN & THUẾ
        // ----------------------------------------------------------------
        Schema::table('profit_distribution_group_members', function (Blueprint $table) {
            $table->foreign('group_id')->references('id')->on('profit_distribution_groups')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('profit_distribution_group_roles', function (Blueprint $table) {
            $table->foreign('group_id')->references('id')->on('profit_distribution_groups')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
        Schema::table('review_rating_rules', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
        Schema::table('tax_rates', function (Blueprint $table) {
            $table->foreign('tax_class_id')->references('id')->on('tax_classes')->onDelete('cascade');
        });
        Schema::table('tax_invoices', function (Blueprint $table) {
            $table->index('order_id');
        });

        // ----------------------------------------------------------------
        // 10. NHÓM ĐƠN HÀNG (ORDERS - DÙNG INDEX VÌ PARTITION)
        // ----------------------------------------------------------------
        Schema::table('orders', function (Blueprint $table) {
            $table->index('customer_id');
            $table->index('order_code');
            $table->index(['status', 'payment_status']);
            $table->index(['created_at', 'status']);
        });
        Schema::table('order_items', function (Blueprint $table) {
            $table->index('order_id');
            $table->index('product_id');
        });
        Schema::table('order_history', function (Blueprint $table) {
            $table->index('order_id');
        });
        Schema::table('order_transactions', function (Blueprint $table) {
            $table->index('order_id');
            $table->index('transaction_code');
        });
        Schema::table('order_returns', function (Blueprint $table) {
            $table->index('order_id');
        });
        Schema::table('payments_transactions', function (Blueprint $table) {
            $table->index('order_id');
            $table->index('reference_code');
            $table->index(['user_id', 'type', 'status']);
        });
        Schema::table('shipping_shipments', function (Blueprint $table) {
            $table->index('order_id');
        });

        // ----------------------------------------------------------------
        // 11. WISHLISTS
        // ----------------------------------------------------------------
        Schema::table('wishlists', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        // Khi rollback không cần xử lý gì đặc biệt
    }
};
