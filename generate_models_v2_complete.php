<?php

// File Path: generate_models_v2_complete.php
// Script V2: Bổ sung toàn bộ Model còn thiếu theo Menu & Controller.
// Tác giả: Gemini AI - MHGR Project.

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

echo "--- BẮT ĐẦU CẬP NHẬT TOÀN BỘ MODEL (VERSION 2) ---\n";

/**
 * DANH SÁCH ĐẦY ĐỦ (FULL MAP)
 * Bao gồm cả các Model cũ (để cập nhật lại) và Model mới bổ sung.
 */
$fullDefinition = [
    // --- 1. NHÓM SALES (BÁN HÀNG) ---
    'Order' => ['table' => 'orders', 'relations' => [
        ['type' => 'BelongsTo', 'model' => 'User', 'fk' => 'user_id'],
        ['type' => 'HasMany', 'model' => 'OrderItem', 'fk' => 'order_id'],
        ['type' => 'HasOne', 'model' => 'Delivery', 'fk' => 'order_id'],
        ['type' => 'HasMany', 'model' => 'OrderReturn', 'fk' => 'order_id'], // Mới
    ]],
    'OrderItem' => ['table' => 'order_items', 'relations' => [
        ['type' => 'BelongsTo', 'model' => 'Order', 'fk' => 'order_id'],
        ['type' => 'BelongsTo', 'model' => 'Product', 'fk' => 'product_id'],
    ]],
    'OrderReturn' => ['table' => 'order_returns', 'relations' => [ // Bổ sung
        ['type' => 'BelongsTo', 'model' => 'Order', 'fk' => 'order_id'],
        ['type' => 'BelongsTo', 'model' => 'User', 'fk' => 'created_by'],
    ]],
    'Invoice' => ['table' => 'invoices', 'relations' => [
        ['type' => 'BelongsTo', 'model' => 'Order', 'fk' => 'order_id'],
    ]],
    'Delivery' => ['table' => 'deliveries', 'relations' => [
        ['type' => 'BelongsTo', 'model' => 'Order', 'fk' => 'order_id'],
    ]],
    'Cart' => ['table' => 'carts', 'relations' => [
        ['type' => 'BelongsTo', 'model' => 'User', 'fk' => 'user_id'],
        ['type' => 'HasMany', 'model' => 'CartItem', 'fk' => 'cart_id'],
    ]],
    'CartItem' => ['table' => 'cart_items', 'relations' => [
        ['type' => 'BelongsTo', 'model' => 'Cart', 'fk' => 'cart_id'],
        ['type' => 'BelongsTo', 'model' => 'Product', 'fk' => 'product_id'],
    ]],

    // --- 2. NHÓM CATALOG (SẢN PHẨM) ---
    'Product' => ['table' => 'products', 'relations' => [
        ['type' => 'BelongsTo', 'model' => 'Category', 'fk' => 'category_id'],
        ['type' => 'HasMany', 'model' => 'ProductVariation', 'fk' => 'product_id'],
        ['type' => 'HasMany', 'model' => 'Image', 'fk' => 'product_id'], // Logic cũ vẫn giữ
        ['type' => 'HasMany', 'model' => 'Review', 'fk' => 'product_id'],
    ]],
    'Category' => ['table' => 'categories', 'relations' => [
        ['type' => 'HasMany', 'model' => 'Product', 'fk' => 'category_id'],
        ['type' => 'BelongsTo', 'model' => 'Category', 'fk' => 'parent_id'],
    ]],
    'Supplier' => ['table' => 'suppliers', 'relations' => [
        ['type' => 'HasMany', 'model' => 'Product', 'fk' => 'supplier_id'],
    ]],
    'Attribute' => ['table' => 'attributes', 'relations' => []],
    'Review' => ['table' => 'reviews', 'relations' => [
        ['type' => 'BelongsTo', 'model' => 'Product', 'fk' => 'product_id'],
    ]],
    'ProductVariation' => ['table' => 'product_variations', 'relations' => [
        ['type' => 'BelongsTo', 'model' => 'Product', 'fk' => 'product_id'],
    ]],

    // --- 3. NHÓM KHO (INVENTORY) ---
    'Warehouse' => ['table' => 'warehouses', 'relations' => [
        ['type' => 'HasMany', 'model' => 'InventoryStock', 'fk' => 'warehouse_id'],
    ]],
    'InventoryStock' => ['table' => 'inventory_stocks', 'relations' => [
        ['type' => 'BelongsTo', 'model' => 'Product', 'fk' => 'product_id'],
        ['type' => 'BelongsTo', 'model' => 'Warehouse', 'fk' => 'warehouse_id'],
    ]],
    'InventoryTransaction' => ['table' => 'inventory_transactions', 'relations' => [
        ['type' => 'BelongsTo', 'model' => 'Product', 'fk' => 'product_id'],
    ]],
    'PurchaseOrder' => ['table' => 'purchase_orders', 'relations' => [
        ['type' => 'BelongsTo', 'model' => 'Supplier', 'fk' => 'supplier_id'],
    ]],

    // --- 4. NHÓM TÀI CHÍNH (FINANCE - BỔ SUNG MỚI) ---
    'Wallet' => ['table' => 'wallets', 'relations' => [
        ['type' => 'BelongsTo', 'model' => 'User', 'fk' => 'user_id'],
        ['type' => 'HasMany', 'model' => 'WalletTransaction', 'fk' => 'wallet_id'],
    ]],
    'Commission' => ['table' => 'commissions', 'relations' => [
        ['type' => 'BelongsTo', 'model' => 'User', 'fk' => 'user_id'],
        ['type' => 'BelongsTo', 'model' => 'Order', 'fk' => 'order_id'],
    ]],
    'ProfitDistribution' => ['table' => 'profit_distributions', 'relations' => []],

    // --- 5. NHÓM MARKETING ---
    'Promotion' => ['table' => 'promotions', 'relations' => []],
    'Coupon' => ['table' => 'coupons', 'relations' => []],
    'FlashSale' => ['table' => 'flash_sales', 'relations' => [
        ['type' => 'BelongsToMany', 'model' => 'Product', 'fk' => ''], // Thường là pivot
    ]],
    'Affiliate' => ['table' => 'affiliates', 'relations' => [
        ['type' => 'BelongsTo', 'model' => 'User', 'fk' => 'user_id'],
    ]],

    // --- 6. NHÓM CONTENT (BỔ SUNG MỚI) ---
    'Post' => ['table' => 'posts', 'relations' => [
        ['type' => 'BelongsTo', 'model' => 'User', 'fk' => 'author_id'],
        ['type' => 'BelongsTo', 'model' => 'Category', 'fk' => 'category_id'],
    ]],
    'Banner' => ['table' => 'banners', 'relations' => []],
    'Menu' => ['table' => 'menus', 'relations' => []], // Menu hiển thị frontend
    'Page' => ['table' => 'pages', 'relations' => []], // Trang tĩnh (About us...)
    'Image' => ['table' => 'images', 'relations' => [
        ['type' => 'MorphTo', 'model' => '', 'fk' => 'imageable'],
    ]],
    'GameSubject' => ['table' => 'game_subjects', 'relations' => []],

    // --- 7. NHÓM CRM & CONSIGNMENT (BỔ SUNG MỚI) ---
    'Chat' => ['table' => 'chats', 'relations' => [ // Hoặc conversations
        ['type' => 'BelongsTo', 'model' => 'User', 'fk' => 'sender_id'],
    ]],
    'Request' => ['table' => 'requests', 'relations' => [
        ['type' => 'BelongsTo', 'model' => 'User', 'fk' => 'user_id'],
    ]],
    'Consignment' => ['table' => 'consignments', 'relations' => [
        ['type' => 'BelongsTo', 'model' => 'User', 'fk' => 'user_id'],
        ['type' => 'BelongsTo', 'model' => 'Product', 'fk' => 'product_id'],
    ]],
    'ConsignmentCustomer' => ['table' => 'consignment_customers', 'relations' => []],

    // --- 8. NHÓM SYSTEM (HỆ THỐNG) ---
    'User' => ['table' => 'users', 'relations' => [
        ['type' => 'BelongsTo', 'model' => 'Role', 'fk' => 'role_id'],
        ['type' => 'HasMany', 'model' => 'UserAddress', 'fk' => 'user_id'],
        ['type' => 'HasOne', 'model' => 'Wallet', 'fk' => 'user_id'],
    ]],
    'Role' => ['table' => 'roles', 'relations' => [
        ['type' => 'BelongsToMany', 'model' => 'Permission', 'fk' => ''],
    ]],
    'Permission' => ['table' => 'permissions', 'relations' => []],
    'Setting' => ['table' => 'settings', 'relations' => []],
    'SystemLog' => ['table' => 'system_logs', 'relations' => [
        ['type' => 'BelongsTo', 'model' => 'User', 'fk' => 'user_id'],
    ]],
    'Location' => ['table' => 'provinces', 'relations' => [ // LocationController thường map với Province
        ['type' => 'HasMany', 'model' => 'Ward', 'fk' => 'province_id'],
    ]],
    'Ward' => ['table' => 'wards', 'relations' => [ // Bổ sung Ward
        ['type' => 'BelongsTo', 'model' => 'Location', 'fk' => 'province_id'], // Map ngược về Location (Province)
    ]],
    'UserAddress' => ['table' => 'user_addresses', 'relations' => [
        ['type' => 'BelongsTo', 'model' => 'User', 'fk' => 'user_id'],
    ]],
    'Wishlist' => ['table' => 'wishlists', 'relations' => [
        ['type' => 'BelongsTo', 'model' => 'User', 'fk' => 'user_id'],
        ['type' => 'BelongsTo', 'model' => 'Product', 'fk' => 'product_id'],
    ]]
];

function generateModelV2($name, $config) {
    $tableName = $config['table'];

    // 1. Kiểm tra bảng tồn tại (Quan trọng: Check cả số ít/nhiều)
    if (!Schema::hasTable($tableName)) {
        if (Schema::hasTable(Str::plural($tableName))) {
            $tableName = Str::plural($tableName); // Fix: banner -> banners
        } elseif (Schema::hasTable(Str::singular($tableName))) {
            $tableName = Str::singular($tableName);
        } else {
            echo "[SKIP] Không tìm thấy bảng DB cho Model: $name (Check table: $tableName)\n";
            return;
        }
    }

    // 2. Get Fillable
    $columns = Schema::getColumnListing($tableName);
    $ignored = ['id', 'created_at', 'updated_at', 'deleted_at', 'email_verified_at', 'remember_token'];
    $fillableCols = array_diff($columns, $ignored);
    $fillableString = "";
    foreach ($fillableCols as $col) {
        $fillableString .= "\n        '$col',";
    }

    // 3. Build Relations
    $methodsCode = "";
    $imports = [
        "Illuminate\Database\Eloquent\Factories\HasFactory" => true,
        "Illuminate\Database\Eloquent\Model" => true,
    ];

    $useTraits = ["HasFactory"];
    if (in_array('deleted_at', $columns)) {
        $imports["Illuminate\Database\Eloquent\SoftDeletes"] = true;
        $useTraits[] = "SoftDeletes";
    }
    $useTraitsStr = implode(", ", $useTraits);

    foreach ($config['relations'] as $rel) {
        $type = $rel['type'];
        $targetModel = $rel['model'];
        $fk = $rel['fk'];

        $imports["Illuminate\Database\Eloquent\Relations\\$type"] = true;

        if ($type === 'MorphTo') {
            $methodsCode .= "\n    public function imageable(): MorphTo\n    {\n        return \$this->morphTo();\n    }\n";
        } else {
            // Naming Convention: HasMany -> plural, BelongsTo -> singular
            $methodName = ($type === 'HasMany' || $type === 'BelongsToMany')
                ? Str::camel(Str::plural($targetModel))
                : Str::camel($targetModel);

            // Fix naming conflicts (Category parent/children)
            if ($targetModel === 'Category' && $fk === 'parent_id') {
                $methodName = ($type === 'HasMany') ? 'children' : 'parent';
            }
            // Fix naming Location -> Ward
            if ($name === 'Location' && $targetModel === 'Ward') $methodName = 'wards';

            $fkParam = $fk ? ", '$fk'" : "";

            $methodsCode .= <<<PHP

    public function $methodName(): $type
    {
        return \$this->lcfirst('$type')($targetModel::class$fkParam);
    }
PHP;
        }
    }

    // 4. Generate Content
    $importString = "";
    foreach (array_keys($imports) as $imp) {
        $importString .= "use $imp;\n";
    }

    $content = <<<PHP
<?php

namespace App\Models;

$importString

class $name extends Model
{
    use $useTraitsStr;

    protected \$table = '$tableName';

    protected \$fillable = [$fillableString
    ];
$methodsCode
}
PHP;

    // Fix lcfirst regex
    $content = str_replace("lcfirst('BelongsTo')", 'belongsTo', $content);
    $content = str_replace("lcfirst('HasMany')", 'hasMany', $content);
    $content = str_replace("lcfirst('HasOne')", 'hasOne', $content);
    $content = str_replace("lcfirst('BelongsToMany')", 'belongsToMany', $content);

    file_put_contents(__DIR__ . "/app/Models/$name.php", $content);
    echo "[SUCCESS] Model: $name (Table: $tableName)\n";
}

foreach ($fullDefinition as $name => $config) {
    generateModelV2($name, $config);
}

echo "\n--- HOÀN TẤT V2! KIỂM TRA LẠI SỐ LƯỢNG FILE --- \n";
?>
