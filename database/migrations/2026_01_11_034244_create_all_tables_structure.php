<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // ----------------------------------------------------------------
        // PHẦN 1: CÁC BẢNG DỮ LIỆU NỀN (MASTER DATA & USERS)
        // ----------------------------------------------------------------

        Schema::create('provinces', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
        });

        Schema::create('wards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedInteger('province_id');
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code')->unique();
            $table->string('description', 500)->nullable();
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('code')->unique();
            $table->string('description', 500)->nullable();
            $table->unsignedInteger('role_group_id')->nullable();
        });

        Schema::create('permissions_role', function (Blueprint $table) {
            $table->unsignedInteger('role_id');
            $table->unsignedInteger('permission_id');
            $table->primary(['role_id', 'permission_id']);
        });

        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username', 50)->nullable()->unique();
            $table->string('name')->nullable();
            $table->string('email', 191)->unique();
            $table->string('phone', 20)->nullable()->unique();
            $table->string('password')->nullable();
            $table->string('user_type', 20)->default('customer');
            $table->tinyInteger('status')->default(1);
            $table->text('two_factor_secret')->nullable();
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip', 45)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('owner_id')->nullable();
            $table->string('store_name')->nullable();
        });

        Schema::create('users_admin_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('full_name');
            $table->string('employee_code', 50)->nullable()->unique();
            $table->string('department', 100)->nullable();
            $table->string('position', 100)->nullable();
            $table->string('avatar')->nullable();
            $table->text('internal_note')->nullable();
            $table->timestamps();
        });

        Schema::create('users_customer_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('first_name', 100)->nullable();
            $table->string('last_name', 100)->nullable();
            $table->string('avatar')->nullable();
            $table->tinyInteger('gender')->nullable();
            $table->date('birthday')->nullable();
            $table->unsignedInteger('loyalty_points')->default(0);
            $table->string('membership_tier', 50)->default('bronze');
            $table->unsignedBigInteger('default_shipping_address_id')->nullable();
            $table->text('bio')->nullable();
            $table->timestamps();
        });

        Schema::create('user_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('phone', 20);
            $table->unsignedBigInteger('ward_id');
            $table->string('address_detail');
            $table->boolean('is_default')->default(0);
            $table->enum('type', ['home', 'office', 'other'])->default('home');
            $table->timestamps();
        });

        Schema::create('user_roles', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('role_id');
            $table->decimal('current_profit_percentage', 5, 2)->default(0);
            $table->boolean('is_work')->default(1);
            $table->timestamps();
        });

        Schema::create('user_permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('permission_id');
            $table->primary(['user_id', 'permission_id']);
        });

        Schema::create('user_region', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('region_id');
            $table->primary(['user_id', 'region_id']);
        });

        Schema::create('user_leave_schedules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->text('reason')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('user_profit_percentage_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('role_id');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedInteger('review_rating_rules_id')->nullable();
            $table->decimal('old_percentage', 5, 2);
            $table->decimal('percentage_change', 5, 2);
            $table->decimal('new_percentage', 5, 2);
            $table->string('reason_code', 100);
            $table->text('notes')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('user_search_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('session_id')->nullable();
            $table->string('keyword');
            $table->integer('hits')->default(1);
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('users_reward_wallets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->decimal('balance', 15, 2)->default(0);
            $table->string('currency', 10)->default('VND');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        Schema::create('users_reward_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('wallet_id');
            $table->decimal('amount', 15, 2);
            $table->string('type', 20);
            $table->text('description')->nullable();
            $table->string('reference_id', 50)->nullable();
            $table->decimal('balance_after', 15, 2);
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('users_social_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('provider', 50);
            $table->string('provider_user_id', 191);
            $table->string('avatar')->nullable();
            $table->text('token')->nullable();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // ----------------------------------------------------------------
        // PHẦN 2: SẢN PHẨM & KHO HÀNG (PRODUCTS & INVENTORY)
        // ----------------------------------------------------------------

        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedTinyInteger('level')->default(0);
            $table->string('path')->nullable();
            $table->integer('position')->default(0);
            $table->boolean('is_active')->default(1);
            $table->boolean('is_featured')->default(0);
            $table->string('icon_url')->nullable();
            $table->string('banner_url')->nullable();
            $table->unsignedBigInteger('tax_class_id')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 500)->nullable();
            $table->string('meta_keywords')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->string('fa_icon')->nullable();
            $table->string('fa_icon_back')->nullable();
            $table->enum('logistics_mode', ['standard', 'instant', 'heavy'])->nullable();
        });

        Schema::create('category_collections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('thumbnail')->nullable();
            $table->boolean('is_active')->default(1);
            $table->integer('position')->default(0);
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('original_product_id')->nullable();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('link_video')->nullable();
            $table->char('status', 255)->default('A');
            $table->integer('is_pin')->default(0);
            $table->integer('point_purchase')->default(0);
            $table->timestamps();
            $table->string('slug')->nullable();
            $table->softDeletes();
            $table->integer('product_quantity')->default(0);
            $table->string('unit')->nullable();
            $table->boolean('must_login')->default(0);
            $table->integer('purchased_quantity')->default(0);
            $table->integer('vat_product')->default(0);
            $table->text('quick_note')->nullable();
            $table->enum('logistics_type', ['standard', 'instant', 'heavy'])->default('standard');
            $table->boolean('stock_status')->default(1);
            $table->boolean('is_hybrid_stock_enabled')->default(1);
            $table->unsignedBigInteger('owner_id')->nullable();
            $table->fullText('name');
        });

        Schema::create('product_variations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id');
            $table->string('sku', 100)->nullable()->unique();
            $table->string('name');
            $table->integer('quantity')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->decimal('price', 15, 2)->nullable();
            $table->decimal('price_sale', 15, 2)->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->string('image_url')->nullable();
            $table->unsignedBigInteger('original_variation_id')->nullable();
        });

        Schema::create('product_attributes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 50)->unique();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('product_attributes_values', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_attribute_id');
            $table->string('value');
            $table->string('color_code', 50)->nullable();
            $table->timestamps();
        });

        Schema::create('product_variation_attribute_values', function (Blueprint $table) {
            $table->unsignedBigInteger('variation_id');
            $table->unsignedBigInteger('attribute_value_id');
        });

        Schema::create('price_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 50)->unique();
            $table->string('name');
            $table->boolean('is_input')->default(0);
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('product_prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_variation_id')->nullable();
            $table->unsignedBigInteger('price_group_id');
            $table->decimal('price', 15, 2)->default(0);
            $table->timestamps();
            $table->unique(['product_id', 'product_variation_id', 'price_group_id'], 'unique_price_lookup_strict');
        });

        Schema::create('product_region', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('region_id');
        });

        Schema::create('product_user', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('user_id');
        });

        Schema::create('category_collection_product', function (Blueprint $table) {
            $table->unsignedBigInteger('collection_id');
            $table->unsignedBigInteger('product_id');
            $table->primary(['collection_id', 'product_id']);
        });

        Schema::create('category_attributes', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('attribute_id');
            $table->primary(['category_id', 'attribute_id']);
        });

        Schema::create('inventory_stocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('warehouse_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_variation_id')->nullable();
            $table->integer('quantity')->default(0);
            $table->integer('reserved_quantity')->default(0);
            $table->string('shelf_location', 50)->nullable();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->unique(['warehouse_id', 'product_id', 'product_variation_id'], 'unique_stock_item');
        });

        Schema::create('inventory_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('warehouse_id')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_variation_id')->nullable();
            $table->enum('type', ['sale', 'import', 'return', 'adjustment', 'transfer']);
            $table->integer('quantity_change');
            $table->integer('quantity_after');
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->string('note')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('inventory_snapshots', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('warehouse_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_variation_id')->nullable();
            $table->integer('quantity')->default(0);
            $table->date('recorded_date');
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('suppliers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('contact_person')->nullable();
            $table->string('contact_phone_1')->nullable();
            $table->string('contact_phone_2')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('tax_code', 50)->nullable();
            $table->string('g_map')->nullable();
            $table->unsignedTinyInteger('rating')->default(1);
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->tinyInteger('frequency_limit')->default(10);
            $table->integer('frequency_worked')->default(0);
        });

        Schema::create('product_sourcing', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('supplier_id');
            $table->boolean('is_priority')->default(0);
            $table->decimal('purchase_price', 15, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('warehouses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('code', 50)->unique();
            $table->enum('type', ['fulfillment', 'store', 'hub', 'kitchen'])->default('fulfillment');
            $table->string('address')->nullable();
            $table->unsignedInteger('province_id')->nullable();
            $table->unsignedBigInteger('ward_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('wishlists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->timestamp('created_at')->useCurrent();
            $table->unique(['user_id', 'product_id'], 'unique_wishlist');
        });

        // ----------------------------------------------------------------
        // PHẦN 3: ĐƠN HÀNG (PARTITIONING 2024 - 2100) & LOGS
        // ----------------------------------------------------------------

        // Tạo chuỗi Partition từ 2024 đến 2100
        $partitions = "";
        for ($year = 2024; $year <= 2100; $year++) {
            $nextYear = $year + 1;
            $partitions .= "PARTITION p_{$year} VALUES LESS THAN ({$nextYear}),\n";
        }
        $partitions .= "PARTITION p_future VALUES LESS THAN MAXVALUE";

        // SQL System Logs (Partitioned p_old)
        $partitionSqlLogs = "PARTITION BY RANGE (year(`created_at`)) (
            PARTITION p_old VALUES LESS THAN (2024),\n" . $partitions . "\n)";

        DB::statement("
            CREATE TABLE `system_logs` (
              `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
              `user_id` bigint(20) UNSIGNED DEFAULT NULL,
              `action` varchar(50) NOT NULL,
              `severity` enum('INFO','WARNING','ERROR','CRITICAL') NOT NULL DEFAULT 'INFO',
              `message` varchar(255) DEFAULT NULL,
              `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
              `ip_address` varchar(45) DEFAULT NULL,
              `user_agent` text DEFAULT NULL,
              `created_at` datetime NOT NULL DEFAULT current_timestamp(),
              PRIMARY KEY (`id`, `created_at`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            $partitionSqlLogs
        ");

        // SQL Orders (Partitioned p_history)
        $partitionSqlOrders = "PARTITION BY RANGE (year(`created_at`)) (
            PARTITION p_history VALUES LESS THAN (2024),\n" . $partitions . "\n)";

        DB::statement("
            CREATE TABLE `orders` (
              `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
              `order_code` varchar(50) NOT NULL COMMENT 'Mã vận đơn',
              `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
              `shipping_manager_id` bigint(20) UNSIGNED DEFAULT NULL,
              `preparing_manager_id` bigint(20) UNSIGNED DEFAULT NULL,
              `shipping_name` varchar(255) NOT NULL,
              `shipping_phone` varchar(20) NOT NULL,
              `shipping_address` text NOT NULL,
              `shipping_province_id` int(10) UNSIGNED DEFAULT NULL,
              `shipping_ward_id` bigint(20) UNSIGNED DEFAULT NULL,
              `shipping_lat` double DEFAULT NULL,
              `shipping_lng` double DEFAULT NULL,
              `total_product_price` decimal(15,2) DEFAULT 0.00,
              `total_shipping_fee` decimal(15,2) DEFAULT 0.00,
              `total_discount` decimal(15,2) DEFAULT 0.00,
              `total_tax_amount` decimal(15,2) DEFAULT 0.00,
              `vat_percentage` int(11) DEFAULT 0,
              `final_amount` decimal(15,2) DEFAULT 0.00,
              `shipping_method_id` bigint(20) UNSIGNED DEFAULT NULL,
              `profit_user` decimal(15,2) DEFAULT 0.00,
              `profit_admin` decimal(15,2) DEFAULT 0.00,
              `vat_user` decimal(15,2) DEFAULT 0.00,
              `vat_admin` decimal(15,2) DEFAULT 0.00,
              `payment_method` varchar(50) DEFAULT 'cod',
              `payment_status` varchar(20) DEFAULT 'unpaid',
              `level_customer` int(4) DEFAULT NULL,
              `customer_group` varchar(255) DEFAULT NULL,
              `status` varchar(20) DEFAULT 'pending',
              `is_packing` tinyint(4) DEFAULT 0,
              `delivery_trip_id` bigint(20) UNSIGNED DEFAULT NULL,
              `note` text DEFAULT NULL,
              `invoice_requested` tinyint(1) DEFAULT 0,
              `created_at` datetime NOT NULL DEFAULT current_timestamp(),
              `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
              `seller_id` bigint(20) UNSIGNED DEFAULT NULL,
              `order_type` varchar(20) DEFAULT 'retail',
              PRIMARY KEY (`id`, `created_at`),
              UNIQUE KEY `unique_order_code_partition` (`order_code`, `created_at`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            $partitionSqlOrders
        ");

        DB::statement("
            CREATE TABLE `order_items` (
              `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
              `order_id` bigint(20) UNSIGNED NOT NULL,
              `product_id` bigint(20) UNSIGNED DEFAULT NULL,
              `applied_promotion_rule_id` bigint(20) UNSIGNED DEFAULT NULL,
              `product_variation_id` bigint(20) UNSIGNED DEFAULT NULL,
              `product_name` varchar(255) NOT NULL,
              `quantity` int(11) NOT NULL,
              `price` decimal(15,2) DEFAULT 0.00,
              `vat_rate` double DEFAULT 0,
              `total_price` decimal(15,2) DEFAULT 0.00,
              `vat_amount` decimal(15,2) DEFAULT 0.00,
              `logistics_type` varchar(20) DEFAULT 'standard',
              `flash_sale_item_id` bigint(20) UNSIGNED DEFAULT NULL,
              `warehouse_id` bigint(20) UNSIGNED DEFAULT NULL,
              `created_at` datetime NOT NULL DEFAULT current_timestamp(),
              PRIMARY KEY (`id`, `created_at`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            $partitionSqlOrders
        ");

        Schema::create('order_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->string('action', 50);
            $table->text('description')->nullable();
            $table->unsignedBigInteger('performed_by')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('order_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('transaction_code', 100);
            $table->decimal('amount', 15, 2)->default(0);
            $table->string('payment_method', 50);
            $table->enum('status', ['pending', 'success', 'failed', 'refunded'])->default('pending');
            $table->text('content')->nullable();
            $table->longText('gateway_response')->nullable();
            $table->timestamps();
        });

        Schema::create('order_returns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('user_id');
            $table->string('reason');
            $table->text('description')->nullable();
            $table->longText('images')->nullable();
            $table->enum('status', ['pending', 'approved', 'shipping', 'received', 'refunded', 'rejected'])->default('pending');
            $table->decimal('refund_amount', 15, 2)->default(0);
            $table->text('admin_note')->nullable();
            $table->timestamps();
        });

        Schema::create('carts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('session_id')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->string('coupon_code', 50)->nullable();
            $table->decimal('total_price', 15, 2)->default(0);
            $table->string('currency', 3)->default('VND');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('metadata')->nullable();
            $table->timestamps();
            $table->integer('total_quantity')->default(0);
        });

        Schema::create('cart_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cart_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_variation_id')->nullable();
            $table->integer('quantity');
            $table->decimal('price_at_add', 15, 2)->default(0);
            $table->longText('options')->nullable();
            $table->timestamps();
        });

        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 50)->unique();
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('warehouse_id');
            $table->unsignedBigInteger('creator_id');
            $table->decimal('total_cost', 15, 2)->default(0);
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending');
            $table->text('note')->nullable();
            $table->date('expected_delivery_date')->nullable();
            $table->timestamps();
        });

        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('purchase_order_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_variation_id')->nullable();
            $table->integer('quantity');
            $table->decimal('import_price', 15, 2)->default(0);
        });

        // ----------------------------------------------------------------
        // PHẦN 4: KHUYẾN MÃI, MARKETING & NỘI DUNG (MARKETING & CONTENT)
        // ----------------------------------------------------------------

        Schema::create('promotions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('display_name')->nullable();
            $table->text('description')->nullable();
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->integer('usage_limit_total')->nullable();
            $table->integer('usage_count_total')->default(0);
            $table->integer('usage_limit_per_customer')->nullable();
            $table->timestamps();
        });

        Schema::create('promotion_rules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('promotion_id');
            $table->string('name')->nullable();
            $table->string('reward_type', 20)->default('discount');
            $table->integer('priority')->default(0);
            $table->string('condition_type', 50);
            $table->longText('condition_data')->nullable();
            $table->string('action_type', 50);
            $table->decimal('action_value', 15, 2);
            $table->decimal('action_value_2', 15, 2)->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->integer('limit_quantity')->nullable();
            $table->integer('current_quantity')->default(0);
            $table->longText('action_data')->nullable();
        });

        Schema::create('promotion_coupons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('promotion_id');
            $table->unsignedBigInteger('promotion_rule_id')->nullable();
            $table->string('code', 50)->collation('utf8mb4_bin');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamp('claimed_at')->nullable();
            $table->string('source_type', 50)->default('manual');
            $table->string('batch_name', 100)->nullable();
            $table->integer('usage_limit')->default(1);
            $table->integer('usage_count')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();
            $table->unique('code');
        });

        Schema::create('promotion_customer_usage', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('promotion_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('coupon_id')->nullable();
            $table->timestamp('used_at')->useCurrent();
        });

        Schema::create('promotion_inventory', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('promotion_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('usage_limit_quantity')->nullable();
            $table->integer('usage_count_quantity')->default(0);
            $table->unique(['promotion_id', 'product_id'], 'uk_promo_product');
        });

        Schema::create('promotion_logic_dictionary', function (Blueprint $table) {
            $table->increments('id');
            $table->string('logic_key', 50);
            $table->enum('type', ['condition', 'action']);
            $table->string('name');
            $table->text('description')->nullable();
            $table->longText('example_data')->nullable();
            $table->unique(['logic_key', 'type'], 'uk_logic_key_type');
        });

        Schema::create('promotion_rule_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('promotion_rule_id');
            $table->unsignedBigInteger('product_id');
            $table->string('role_type', 20)->default('target');
            $table->unique(['promotion_rule_id', 'product_id', 'role_type'], 'uk_rule_product_role');
        });

        Schema::create('affiliate_links', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('code', 50)->unique();
            $table->integer('clicks')->default(0);
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('affiliate_commissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('affiliate_user_id');
            $table->unsignedBigInteger('order_id');
            $table->decimal('amount', 15, 2);
            $table->enum('status', ['pending', 'approved', 'paid', 'cancelled'])->default('pending');
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('flash_sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->boolean('is_active')->default(1);
        });

        Schema::create('flash_sale_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('flash_sale_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_variation_id')->nullable();
            $table->decimal('price', 15, 2);
            $table->integer('quantity');
            $table->integer('sold')->default(0);
        });

        Schema::create('images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('url');
            $table->string('type', 50)->nullable();
            $table->string('alt_text')->nullable();
            $table->text('caption')->nullable();
            $table->string('filename_original')->nullable();
            $table->unsignedInteger('size_kb')->default(0);
            $table->boolean('status')->default(1);
            $table->longText('meta')->nullable();
            $table->unsignedBigInteger('uploaded_by_user_id')->nullable();
            $table->timestamps();
        });

        Schema::create('imageables', function (Blueprint $table) {
            $table->unsignedBigInteger('image_id');
            $table->unsignedBigInteger('imageable_id');
            $table->string('imageable_type');
            $table->unsignedInteger('position')->default(0);
            $table->longText('meta')->nullable();
            $table->primary(['image_id', 'imageable_id', 'imageable_type']);
        });

        Schema::create('product_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id');
            $table->string('image_url', 500);
            $table->string('image_path', 500)->nullable();
            $table->boolean('is_main')->default(0);
            $table->integer('sort_order')->default(0);
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('product_variation_images', function (Blueprint $table) {
            $table->unsignedBigInteger('product_variation_id');
            $table->unsignedBigInteger('image_id');
            $table->unsignedInteger('position')->default(0);
        });

        Schema::create('product_variation_images_pivot', function (Blueprint $table) {
            $table->unsignedBigInteger('product_variation_id');
            $table->unsignedBigInteger('product_image_id');
            $table->boolean('is_avatar_variant')->default(0);
        });

        Schema::create('product_videos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id');
            $table->enum('type', ['review', 'intro', 'tutorial', 'user_feedback'])->default('intro');
            $table->enum('platform', ['youtube', 'tiktok', 'vimeo', 'upload'])->default('youtube');
            $table->string('video_url', 500);
            $table->string('thumbnail_url', 500)->nullable();
            $table->string('title')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(1);
        });

        Schema::create('banners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('thumbnail_url');
            $table->integer('position');
            $table->boolean('is_deleted')->default(0);
            $table->timestamps();
        });

        Schema::create('news', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content');
            $table->string('thumbnail_url')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->unsignedBigInteger('author_id')->nullable();
            $table->timestamps();
        });

        Schema::create('contents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('position');
            $table->text('content');
            $table->timestamps();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('slug')->nullable();
            $table->string('short_description')->nullable();
            $table->string('description')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        Schema::create('menus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('position', 50)->unique();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });

        Schema::create('menu_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('menu_id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('title');
            $table->string('icon_url')->nullable();
            $table->string('class_name', 100)->nullable();
            $table->string('type', 50)->default('custom_link');
            $table->string('url')->nullable();
            $table->unsignedBigInteger('related_id')->nullable();
            $table->integer('sort_order')->default(0);
            $table->string('target', 20)->default('_self');
            $table->timestamps();
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('setting_code');
            $table->text('setting_value');
            $table->boolean('is_deleted')->default(0);
            $table->timestamps();
        });

        Schema::create('requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('content');
            $table->timestamps();
        });

        Schema::create('product_reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('customer_id');
            $table->tinyInteger('rating')->default(5);
            $table->text('comment')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });

        Schema::create('review_rating_rules', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('role_id');
            $table->unsignedTinyInteger('rating_stars');
            $table->decimal('percentage_change', 5, 2);
            $table->string('description')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->unique(['role_id', 'rating_stars'], 'uk_role_rating');
        });

        // ----------------------------------------------------------------
        // PHẦN 5: HỆ THỐNG VẬN CHUYỂN, GIAO TIẾP & KHÁC (SHIPPING, CHAT, OTHER)
        // ----------------------------------------------------------------

        Schema::create('shipping_methods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('code', 50);
            $table->string('description')->nullable();
            $table->decimal('base_price', 15, 2)->default(0);
            $table->boolean('is_active')->default(1);
            $table->integer('position')->default(0);
            $table->timestamps();
        });

        Schema::create('shipping_partners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('code', 50)->unique();
            $table->string('api_url')->nullable();
            $table->enum('type', ['internal', 'external'])->default('external');
            $table->boolean('is_active')->default(1);
        });

        Schema::create('shipping_drivers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('shipping_partner_id')->nullable();
            $table->string('vehicle_plate', 20)->nullable();
            $table->string('vehicle_type', 20)->default('motorbike');
            $table->double('current_lat')->nullable();
            $table->double('current_lng')->nullable();
            $table->enum('status', ['offline', 'available', 'busy'])->default('offline');
        });

        Schema::create('shipping_shipments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('warehouse_id');
            $table->string('shipping_method', 50);
            $table->unsignedInteger('shipping_partner_id')->nullable();
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->string('tracking_code', 50)->nullable();
            $table->decimal('cod_amount', 15, 2)->default(0);
            $table->decimal('shipping_fee', 15, 2)->default(0);
            $table->string('status', 50)->default('ready_to_pick');
            $table->string('proof_image')->nullable();
            $table->timestamp('estimated_delivery_at')->nullable();
            $table->timestamps();
        });

        Schema::create('shipping_shipment_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('shipment_id');
            $table->unsignedBigInteger('order_item_id');
            $table->integer('quantity');
        });

        Schema::create('shipping_rates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('province_id');
            $table->string('name');
            $table->decimal('min_weight', 8, 2)->default(0);
            $table->decimal('max_weight', 8, 2)->default(0);
            $table->double('base_fee')->default(0);
            $table->double('step_fee')->default(0);
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });

        Schema::create('delivery_trips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('trip_code', 50);
            $table->unsignedBigInteger('shipper_id')->nullable();
            $table->string('status', 50)->default('pending');
            $table->integer('total_orders')->default(0);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });

        Schema::create('delivery_attempts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('shipper_id')->nullable();
            $table->integer('attempt_number')->default(1);
            $table->string('status', 50);
            $table->text('reason')->nullable();
            $table->string('proof_image_url')->nullable();
            $table->timestamp('attempted_at')->useCurrent();
            $table->timestamps();
        });

        Schema::create('shipping_manager_reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('shipping_manager_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedTinyInteger('rating');
            $table->text('comment')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamp('created_at')->useCurrent();
            $table->unique('order_id', 'unique_review_per_order');
        });

        Schema::create('chat_conversations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('type', ['private', 'group', 'support'])->default('private');
            $table->timestamp('last_message_at')->nullable();
            $table->timestamps();
        });

        Schema::create('chat_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('conversation_id');
            $table->unsignedBigInteger('sender_id');
            $table->enum('type', ['text', 'image', 'file', 'product_link', 'order_link'])->default('text');
            $table->text('content')->nullable();
            $table->longText('meta_data')->nullable();
            $table->boolean('is_deleted')->default(0);
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('chat_participants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('conversation_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamp('joined_at')->useCurrent();
            $table->timestamp('last_read_at')->nullable();
        });

        Schema::create('game_subjects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon_url');
            $table->boolean('is_active')->default(1);
            $table->integer('position')->default(0);
            $table->timestamps();
        });

        Schema::create('game_languages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 10)->unique();
            $table->string('name', 50);
        });

        Schema::create('game_voices', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('language_id');
            $table->string('name', 100);
            $table->text('description')->nullable();
        });

        Schema::create('game_audio_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('subject_id');
            $table->unsignedInteger('voice_id');
            $table->string('audio_url');
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('consignment_customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('customer_id');
            $table->string('note', 500)->nullable();
            $table->bigInteger('money_base')->default(0);
            $table->decimal('current_debt', 15, 2)->default(0);
            $table->dateTime('last_order_time')->nullable();
            $table->boolean('is_draft')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('consignment_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('customer_id');
            $table->tinyInteger('category_id')->default(1);
            $table->string('name');
            $table->string('note', 750)->nullable();
            $table->decimal('total_money', 15, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->boolean('is_temp')->default(1);
            $table->decimal('loi_nhuan_admin', 15, 2)->default(0);
            $table->decimal('vat_admin', 15, 2)->default(0);
            $table->string('setting_vat')->nullable();
            $table->integer('level_customer')->nullable();
            $table->integer('phan_tram_vat')->nullable();
        });

        Schema::create('consignment_order_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('consignment_id');
            $table->bigInteger('product_id');
            $table->unsignedBigInteger('product_variation_id')->nullable();
            $table->string('item_name');
            $table->integer('quantity');
            $table->decimal('amount', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);
            $table->text('type')->nullable();
            $table->text('note')->nullable();
            $table->string('extend_note', 500)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->boolean('is_temp')->default(1);
            $table->boolean('is_old_revision')->default(0);
            $table->decimal('vat_of_item', 15, 2)->default(0);
        });

        Schema::create('consignment_stocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('customer_id');
            $table->bigInteger('product_id');
            $table->unsignedBigInteger('product_variation_id')->nullable();
            $table->string('item_name')->nullable();
            $table->text('type')->nullable();
            $table->text('url_image')->nullable();
            $table->integer('quantity')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->double('total_money')->default(0);
            $table->boolean('quan_tam')->default(1);
            $table->double('level_1_price_bak')->default(0);
            $table->unique(['customer_id', 'product_id', 'product_variation_id'], 'unique_stock');
        });

        Schema::create('booking_profit', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('user_id');
            $table->decimal('profit_percentage_backup', 5, 2)->nullable();
            $table->decimal('money_profit', 15, 2)->default(0);
            $table->string('profit_type', 100);
            $table->string('source_description')->nullable();
            $table->timestamps();
        });

        Schema::create('booking_status', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('delivery_progress_sort')->default(0);
            $table->string('delivery_progress_name');
            $table->string('delivery_progress_code', 50)->unique();
            $table->string('class_html', 100)->nullable();
            $table->string('fa_icon', 100)->nullable();
            $table->text('description')->nullable();
        });

        Schema::create('booking_status_transitions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('from_status_code', 50);
            $table->string('to_status_code', 50);
            $table->string('permission_code_required');
            $table->string('description', 500)->nullable();
            $table->unique(['from_status_code', 'to_status_code'], 'unique_transition');
        });

        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->integer('expiration');
        });

        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->integer('expiration');
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });

        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });

        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->integer('total_jobs');
            $table->integer('pending_jobs');
            $table->integer('failed_jobs');
            $table->longText('failed_job_ids');
            $table->mediumText('options')->nullable();
            $table->integer('cancelled_at')->nullable();
            $table->integer('created_at');
            $table->integer('finished_at')->nullable();
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->string('type');
            $table->string('notifiable_type');
            $table->unsignedBigInteger('notifiable_id');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            $table->index(['notifiable_type', 'notifiable_id']);
        });

        Schema::create('packings', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->tinyInteger('is_packing')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::create('packing_detail', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->bigInteger('order_id');
            $table->bigInteger('packing_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::create('payments_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('transaction_code', 64)->unique();
            $table->string('reference_code', 100)->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->decimal('amount', 20, 2);
            $table->string('currency', 3)->default('VND');
            $table->enum('type', ['payment', 'refund', 'payout', 'topup', 'withdrawal', 'fee', 'adjustment']);
            $table->string('payment_method', 50);
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'cancelled', 'refunded'])->default('pending');
            $table->longText('extra_data')->nullable();
            $table->timestamp('performed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tokenable_type');
            $table->unsignedBigInteger('tokenable_id');
            $table->string('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            $table->index(['tokenable_type', 'tokenable_id']);
        });

        Schema::create('profit_distribution_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->decimal('percentage', 5, 2);
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });

        Schema::create('profit_distribution_group_members', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('group_id');
            $table->unsignedBigInteger('user_id');
            $table->decimal('percentage_min', 5, 2)->default(0);
            $table->decimal('percentage_max', 5, 2);
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });

        Schema::create('profit_distribution_group_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('group_id');
            $table->unsignedInteger('role_id');
            $table->decimal('percentage', 5, 2);
            $table->timestamps();
        });

        // Bảng Pulse (Laravel Pulse) - Thêm để đầy đủ nếu sau này cài package
        Schema::create('pulse_aggregates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('bucket');
            $table->unsignedMediumInteger('period');
            $table->string('type');
            $table->mediumText('key');
            $table->binary('key_hash', 16)->virtualAs('unhex(md5(`key`))');
            $table->string('aggregate');
            $table->decimal('value', 20, 2);
            $table->unsignedInteger('count')->nullable();
            $table->unique(['bucket', 'period', 'type', 'aggregate', 'key_hash'], 'pulse_aggr_unique');
        });

        Schema::create('pulse_entries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('timestamp');
            $table->string('type');
            $table->mediumText('key');
            $table->mediumText('value')->nullable();
            $table->index('timestamp');
        });

        Schema::create('pulse_values', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('timestamp');
            $table->string('type');
            $table->mediumText('key');
            $table->binary('key_hash', 16)->virtualAs('unhex(md5(`key`))');
            $table->mediumText('value');
            $table->unique(['type', 'key_hash']);
        });

        Schema::create('tax_classes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('code', 50);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('tax_invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->string('invoice_number', 50)->unique();
            $table->string('tax_code', 50)->nullable();
            $table->string('company_name')->nullable();
            $table->text('company_address')->nullable();
            $table->decimal('subtotal', 15, 2);
            $table->decimal('total_tax', 15, 2);
            $table->decimal('total_amount', 15, 2);
            $table->string('status', 20)->default('draft');
            $table->timestamp('issued_at')->nullable();
            $table->timestamps();
        });

        Schema::create('tax_rates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tax_class_id');
            $table->string('name');
            $table->decimal('rate', 8, 4);
            $table->integer('priority')->default(1);
            $table->timestamp('valid_from')->nullable();
            $table->timestamp('valid_until')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Khi rollback, xóa toàn bộ bảng (trừ migrations) để tránh lỗi
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $tables = DB::select('SHOW TABLES');
        foreach ($tables as $table) {
            $tableName = array_values((array)$table)[0];
            if ($tableName !== 'migrations') {
                Schema::dropIfExists($tableName);
            }
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
};
