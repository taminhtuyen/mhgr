<?php

// File Path: generate_final_models.php
// Script tạo Model "Thông minh" dựa trên phân tích Cấu trúc Bảng & Khóa ngoại.
// Tác giả: Gemini AI - Dành riêng cho dự án MHGR.

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

echo "--- BẮT ĐẦU KHỞI TẠO HỆ THỐNG MODEL THÔNG MINH ---\n";

/**
 * 1. TRÍ TUỆ CỦA GEMINI: BẢN ĐỒ QUAN HỆ (RELATIONSHIP MAP)
 * Được xây dựng dựa trên file 'add_foreign_keys_constraints.php' và Menu Admin.
 */
$modelDefinitions = [
    // --- NHÓM CATALOG (SẢN PHẨM) ---
    'Product' => [
        'table' => 'products',
        'relations' => [
            ['type' => 'BelongsTo', 'model' => 'Category', 'fk' => 'category_id', 'comment' => 'Danh mục sản phẩm'],
            ['type' => 'BelongsTo', 'model' => 'Supplier', 'fk' => 'supplier_id', 'comment' => 'Nhà cung cấp'],
            ['type' => 'HasMany', 'model' => 'ProductVariation', 'fk' => 'product_id', 'comment' => 'Các biến thể (Màu/Size)'],
            ['type' => 'HasMany', 'model' => 'Image', 'fk' => 'product_id', 'comment' => 'Album ảnh sản phẩm'],
            ['type' => 'HasMany', 'model' => 'Review', 'fk' => 'product_id', 'comment' => 'Đánh giá khách hàng'],
            ['type' => 'HasMany', 'model' => 'OrderItem', 'fk' => 'product_id', 'comment' => 'Được mua trong các đơn hàng'],
        ]
    ],
    'Category' => [
        'table' => 'categories', // Hoặc 'product_categories' tuỳ DB
        'relations' => [
            ['type' => 'HasMany', 'model' => 'Product', 'fk' => 'category_id', 'comment' => 'Sản phẩm trong danh mục'],
            ['type' => 'BelongsTo', 'model' => 'Category', 'fk' => 'parent_id', 'comment' => 'Danh mục cha'],
            ['type' => 'HasMany', 'model' => 'Category', 'fk' => 'parent_id', 'comment' => 'Các danh mục con'],
        ]
    ],
    'Supplier' => [
        'table' => 'suppliers',
        'relations' => [
            ['type' => 'HasMany', 'model' => 'Product', 'fk' => 'supplier_id', 'comment' => 'Sản phẩm cung cấp'],
            ['type' => 'HasMany', 'model' => 'PurchaseOrder', 'fk' => 'supplier_id', 'comment' => 'Đơn nhập hàng từ NCC này'],
        ]
    ],
    'ProductVariation' => [
        'table' => 'product_variations',
        'relations' => [
            ['type' => 'BelongsTo', 'model' => 'Product', 'fk' => 'product_id', 'comment' => 'Thuộc về sản phẩm gốc'],
        ]
    ],
    'Attribute' => [
        'table' => 'attributes',
        'relations' => []
    ],
    'Review' => [
        'table' => 'reviews',
        'relations' => [
            ['type' => 'BelongsTo', 'model' => 'Product', 'fk' => 'product_id', 'comment' => 'Sản phẩm được đánh giá'],
            ['type' => 'BelongsTo', 'model' => 'User', 'fk' => 'user_id', 'comment' => 'Người đánh giá'],
        ]
    ],

    // --- NHÓM SALES (BÁN HÀNG) ---
    'Order' => [
        'table' => 'orders',
        'relations' => [
            ['type' => 'BelongsTo', 'model' => 'User', 'fk' => 'user_id', 'comment' => 'Khách hàng đặt đơn'],
            ['type' => 'HasMany', 'model' => 'OrderItem', 'fk' => 'order_id', 'comment' => 'Chi tiết hàng hóa'],
            ['type' => 'HasOne', 'model' => 'Invoice', 'fk' => 'order_id', 'comment' => 'Hóa đơn tài chính'],
            ['type' => 'HasOne', 'model' => 'Delivery', 'fk' => 'order_id', 'comment' => 'Vận đơn giao hàng'],
            ['type' => 'HasMany', 'model' => 'OrderHistory', 'fk' => 'order_id', 'comment' => 'Lịch sử trạng thái đơn'],
            ['type' => 'HasMany', 'model' => 'InventoryTransaction', 'fk' => 'order_id', 'comment' => 'Giao dịch kho liên quan'],
        ]
    ],
    'OrderItem' => [
        'table' => 'order_items',
        'relations' => [
            ['type' => 'BelongsTo', 'model' => 'Order', 'fk' => 'order_id', 'comment' => 'Thuộc đơn hàng'],
            ['type' => 'BelongsTo', 'model' => 'Product', 'fk' => 'product_id', 'comment' => 'Sản phẩm'],
            ['type' => 'BelongsTo', 'model' => 'ProductVariation', 'fk' => 'product_variation_id', 'comment' => 'Biến thể (nếu có)'],
        ]
    ],
    'Invoice' => [
        'table' => 'invoices',
        'relations' => [
            ['type' => 'BelongsTo', 'model' => 'Order', 'fk' => 'order_id', 'comment' => 'Hóa đơn của đơn hàng'],
        ]
    ],
    'Delivery' => [
        'table' => 'deliveries', // shipment
        'relations' => [
            ['type' => 'BelongsTo', 'model' => 'Order', 'fk' => 'order_id', 'comment' => 'Giao cho đơn hàng'],
            ['type' => 'BelongsTo', 'model' => 'User', 'fk' => 'shipper_id', 'comment' => 'Shipper giao hàng'],
        ]
    ],
    'Cart' => [
        'table' => 'carts',
        'relations' => [
            ['type' => 'BelongsTo', 'model' => 'User', 'fk' => 'user_id', 'comment' => 'Giỏ hàng của User'],
            ['type' => 'HasMany', 'model' => 'CartItem', 'fk' => 'cart_id', 'comment' => 'Sản phẩm trong giỏ'],
        ]
    ],
    'CartItem' => [
        'table' => 'cart_items',
        'relations' => [
            ['type' => 'BelongsTo', 'model' => 'Cart', 'fk' => 'cart_id', 'comment' => 'Thuộc giỏ hàng'],
            ['type' => 'BelongsTo', 'model' => 'Product', 'fk' => 'product_id', 'comment' => 'Sản phẩm'],
        ]
    ],

    // --- NHÓM INVENTORY (KHO HÀNG) ---
    'Warehouse' => [
        'table' => 'warehouses',
        'relations' => [
            ['type' => 'HasMany', 'model' => 'InventoryStock', 'fk' => 'warehouse_id', 'comment' => 'Tồn kho tại đây'],
        ]
    ],
    'InventoryStock' => [
        'table' => 'inventory_stocks',
        'relations' => [
            ['type' => 'BelongsTo', 'model' => 'Warehouse', 'fk' => 'warehouse_id', 'comment' => 'Kho hàng'],
            ['type' => 'BelongsTo', 'model' => 'Product', 'fk' => 'product_id', 'comment' => 'Sản phẩm tồn'],
        ]
    ],
    'InventoryTransaction' => [
        'table' => 'inventory_transactions',
        'relations' => [
            ['type' => 'BelongsTo', 'model' => 'Product', 'fk' => 'product_id', 'comment' => 'Sản phẩm giao dịch'],
            ['type' => 'BelongsTo', 'model' => 'Warehouse', 'fk' => 'warehouse_id', 'comment' => 'Tại kho'],
            ['type' => 'BelongsTo', 'model' => 'Order', 'fk' => 'order_id', 'comment' => 'Theo đơn hàng (nếu xuất)'],
            ['type' => 'BelongsTo', 'model' => 'PurchaseOrder', 'fk' => 'purchase_order_id', 'comment' => 'Theo phiếu nhập (nếu nhập)'],
        ]
    ],
    'PurchaseOrder' => [
        'table' => 'purchase_orders',
        'relations' => [
            ['type' => 'BelongsTo', 'model' => 'Supplier', 'fk' => 'supplier_id', 'comment' => 'Nhập từ NCC'],
            ['type' => 'BelongsTo', 'model' => 'Warehouse', 'fk' => 'warehouse_id', 'comment' => 'Nhập về kho'],
            ['type' => 'BelongsTo', 'model' => 'User', 'fk' => 'creator_id', 'comment' => 'Người tạo phiếu'],
        ]
    ],

    // --- NHÓM MARKETING ---
    'Promotion' => [
        'table' => 'promotions',
        'relations' => []
    ],
    'Coupon' => [
        'table' => 'coupons',
        'relations' => [
            ['type' => 'HasMany', 'model' => 'Order', 'fk' => 'coupon_id', 'comment' => 'Các đơn hàng áp dụng'],
        ]
    ],
    'FlashSale' => [
        'table' => 'flash_sales',
        'relations' => [
            ['type' => 'HasMany', 'model' => 'Product', 'fk' => 'flash_sale_id', 'comment' => 'Sản phẩm trong đợt Sale (Pivot thực tế)'],
        ]
    ],
    'Affiliate' => [
        'table' => 'affiliates',
        'relations' => [
            ['type' => 'BelongsTo', 'model' => 'User', 'fk' => 'user_id', 'comment' => 'CTV'],
        ]
    ],

    // --- NHÓM CONTENT & SYSTEM ---
    'User' => [
        'table' => 'users',
        'relations' => [
            ['type' => 'HasOne', 'model' => 'Cart', 'fk' => 'user_id', 'comment' => 'Giỏ hàng'],
            ['type' => 'HasMany', 'model' => 'Order', 'fk' => 'user_id', 'comment' => 'Đơn hàng đã đặt'],
            ['type' => 'BelongsTo', 'model' => 'Role', 'fk' => 'role_id', 'comment' => 'Vai trò hệ thống'],
            ['type' => 'HasMany', 'model' => 'UserAddress', 'fk' => 'user_id', 'comment' => 'Sổ địa chỉ'],
            ['type' => 'HasMany', 'model' => 'Review', 'fk' => 'user_id', 'comment' => 'Đánh giá đã viết'],
        ]
    ],
    'Role' => [
        'table' => 'roles',
        'relations' => [
            ['type' => 'HasMany', 'model' => 'User', 'fk' => 'role_id', 'comment' => 'Người dùng có vai trò này'],
            ['type' => 'BelongsToMany', 'model' => 'Permission', 'fk' => '', 'comment' => 'Quyền hạn (Pivot permissions_role)'],
        ]
    ],
    'Permission' => [
        'table' => 'permissions',
        'relations' => [
            ['type' => 'BelongsToMany', 'model' => 'Role', 'fk' => '', 'comment' => 'Vai trò sở hữu quyền này'],
        ]
    ],
    'Image' => [
        'table' => 'images',
        'relations' => [
            ['type' => 'MorphTo', 'model' => '', 'fk' => 'imageable', 'comment' => 'Đa hình (Product, Post, User...)'],
        ]
    ],
    'Post' => [
        'table' => 'posts',
        'relations' => [
            ['type' => 'BelongsTo', 'model' => 'User', 'fk' => 'author_id', 'comment' => 'Tác giả'],
            ['type' => 'BelongsTo', 'model' => 'Category', 'fk' => 'category_id', 'comment' => 'Chuyên mục bài viết'],
        ]
    ]
];

// --- HÀM TẠO MODEL ---
function generateSmartModel($name, $config) {
    $tableName = $config['table'];

    // 1. Kiểm tra bảng tồn tại
    if (!Schema::hasTable($tableName)) {
        // Thử tìm bảng số nhiều nếu tên cấu hình sai
        if (Schema::hasTable(Str::plural($tableName))) {
            $tableName = Str::plural($tableName);
        } else {
            echo "[SKIP] Không tìm thấy bảng DB cho Model: $name ($tableName)\n";
            return;
        }
    }

    // 2. Lấy danh sách cột cho \$fillable
    $columns = Schema::getColumnListing($tableName);
    $ignored = ['id', 'created_at', 'updated_at', 'deleted_at', 'email_verified_at', 'remember_token'];
    $fillableCols = array_diff($columns, $ignored);
    $fillableString = "";
    foreach ($fillableCols as $col) {
        $fillableString .= "\n        '$col',";
    }

    // 3. Xây dựng Relationship Methods
    $methodsCode = "";
    $imports = [
        "Illuminate\Database\Eloquent\Factories\HasFactory" => true,
        "Illuminate\Database\Eloquent\Model" => true,
    ];

    // Thêm SoftDeletes nếu có cột deleted_at
    $useTraits = ["HasFactory"];
    if (in_array('deleted_at', $columns)) {
        $imports["Illuminate\Database\Eloquent\SoftDeletes"] = true;
        $useTraits[] = "SoftDeletes";
    }
    $useTraitsStr = implode(", ", $useTraits);

    foreach ($config['relations'] as $rel) {
        $type = $rel['type']; // BelongsTo, HasMany...
        $targetModel = $rel['model'];
        $fk = $rel['fk'];
        $comment = $rel['comment'];

        $imports["Illuminate\Database\Eloquent\Relations\\$type"] = true;

        // Tên hàm: belongsTo -> singular (category), hasMany -> plural (items)
        if ($type === 'BelongsTo' || $type === 'HasOne') {
            $methodName = Str::camel($targetModel); // Product -> product
            // Fix: category_id -> category
            if ($targetModel === 'Category' && $fk === 'parent_id') $methodName = 'parent';
        } else {
            $methodName = Str::camel(Str::plural($targetModel)); // Product -> products
            // Fix: parent_id -> children
            if ($targetModel === 'Category' && $fk === 'parent_id') $methodName = 'children';
            if ($type === 'HasMany' && $targetModel === 'OrderItem') $methodName = 'items';
        }

        // Logic return code
        if ($type === 'MorphTo') {
            $methodsCode .= <<<PHP

    /**
     * $comment
     */
    public function imageable(): MorphTo
    {
        return \$this->morphTo();
    }
PHP;
        } else {
            // Nếu có FK cụ thể thì thêm vào, nếu không để Laravel tự đoán
            $fkParam = $fk ? ", '$fk'" : "";

            $methodsCode .= <<<PHP

    /**
     * $comment
     */
    public function $methodName(): $type
    {
        return \$this->lcfirst('$type')($targetModel::class$fkParam);
    }
PHP;
        }
    }

    // Xử lý Import String
    $importString = "";
    foreach (array_keys($imports) as $imp) {
        $importString .= "use $imp;\n";
    }

    // 4. Tạo nội dung file
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

    // Fix lcfirst trong heredoc
    $content = str_replace("lcfirst('BelongsTo')", 'belongsTo', $content);
    $content = str_replace("lcfirst('HasMany')", 'hasMany', $content);
    $content = str_replace("lcfirst('HasOne')", 'hasOne', $content);
    $content = str_replace("lcfirst('BelongsToMany')", 'belongsToMany', $content);

    // Ghi file
    $filePath = __DIR__ . "/app/Models/$name.php";
    file_put_contents($filePath, $content);
    echo "[SUCCESS] Đã tạo Smart Model: $name (Table: $tableName)\n";
}

// --- THỰC THI ---
foreach ($modelDefinitions as $modelName => $config) {
    generateSmartModel($modelName, $config);
}

echo "\n--- HOÀN TẤT TOÀN BỘ! HÃY KIỂM TRA FOLDER APP/MODELS ---\n";
?>
