<?php

// File Path: update_controllers_views.php
// Script cập nhật Controller để trỏ về đúng View Index mới.
// Hướng dẫn: Chạy lệnh "php update_controllers_views.php"

echo "--- BẮT ĐẦU CẬP NHẬT VIEW TRONG CONTROLLER ---\n";

$baseControllerPath = __DIR__ . '/app/Http/Controllers/Admin';

// Cấu trúc Controller (Giống các bước trước)
$structure = [
    'Dashboard' => ['DashboardController.php'],
    'Sales' => [
        'OrderController.php', 'DeliveryController.php', 'ReturnController.php',
        'InvoiceController.php', 'CartController.php'
    ],
    'Catalog' => [
        'ProductController.php', 'CategoryController.php', 'AttributeController.php',
        'SupplierController.php', 'ReviewController.php'
    ],
    'Inventory' => [
        'InventoryStockController.php', 'WarehouseController.php',
        'PurchaseOrderController.php', 'InventoryTransactionController.php'
    ],
    'System' => [
        'SettingController.php', 'UserController.php', 'RoleController.php',
        'LocationController.php', 'SystemLogController.php'
    ],
    'Finance' => [
        'ProfitDistributionController.php', 'WalletController.php', 'CommissionController.php'
    ],
    'Marketing' => [
        'PromotionController.php', 'CouponController.php', 'FlashSaleController.php', 'AffiliateController.php'
    ],
    'Content' => [
        'PostController.php', 'BannerController.php', 'MenuController.php',
        'PageController.php', 'ImageController.php', 'GameSubjectController.php'
    ],
    'CRM' => [
        'CustomerController.php', 'ChatController.php', 'RequestController.php'
    ],
    'Consignment' => [
        'ConsignmentController.php', 'ConsignmentCustomerController.php'
    ]
];

// Hàm chuyển đổi tên: CamelCase -> kebab-case-plural (Order -> orders)
function normalizeViewName($name) {
    $kebab = strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $name));
    return $kebab . 's';
}

foreach ($structure as $group => $files) {
    $groupFolder = strtolower($group);

    foreach ($files as $fileName) {
        $filePath = "$baseControllerPath/$group/$fileName";

        if (!file_exists($filePath)) {
            echo "[WARNING] Không tìm thấy file: $filePath\n";
            continue;
        }

        // 1. Xác định đường dẫn view mới
        $entityName = str_replace('Controller.php', '', $fileName);
        $viewFolder = normalizeViewName($entityName);

        // Ví dụ: admin.sales.orders.index
        $newViewPath = "admin.$groupFolder.$viewFolder.index";

        // 2. Đọc nội dung file
        $content = file_get_contents($filePath);

        // 3. Logic tìm kiếm và thay thế (Regex)
        // Tìm đoạn code: return view('admin.schema-view', [ ... ]);
        // Pattern này cố gắng bắt title để giữ lại

        $pattern = "/return view\(\s*'admin\.schema-view'\s*,\s*\[(.*?)\]\s*\);/s";

        if (preg_match($pattern, $content, $matches)) {
            $arrayBody = $matches[1];

            // Tìm title cũ trong mảng
            $title = "Quản lý $entityName"; // Title mặc định nếu không tìm thấy
            if (preg_match("/'title'\s*=>\s*'(.*?)'/", $arrayBody, $titleMatch)) {
                $title = $titleMatch[1];
            }

            // Tạo nội dung thay thế mới (Code sạch)
            $replacement = "return view('$newViewPath', [\n            'title' => '$title'\n        ]);";

            // Thực hiện replace
            $newContent = preg_replace($pattern, $replacement, $content);

            // 4. (Tùy chọn) Xóa bớt các dòng biến thừa như $tableName = ... nếu nó nằm ngay trên
            // Tìm: $tableName = '...'; [Khoảng trắng] return view...
            $cleanupPattern = "/(\s*)\\\$tableName\s*=\s*['\"].*?['\"];\s*return view/";
            $newContent = preg_replace($cleanupPattern, "$1return view", $newContent);

            // Ghi file
            if (file_put_contents($filePath, $newContent)) {
                echo "[UPDATE] $fileName -> Trỏ về view: $newViewPath\n";
            } else {
                echo "[ERROR] Không thể ghi file $fileName\n";
            }
        } else {
            // Trường hợp không tìm thấy 'admin.schema-view' (có thể đã sửa rồi hoặc code khác)
            // Kiểm tra xem đã trỏ đúng chưa
            if (strpos($content, "'$newViewPath'") !== false) {
                echo "[OK] $fileName đã trỏ đúng view. Bỏ qua.\n";
            } else {
                echo "[SKIP] $fileName: Không tìm thấy mẫu code cũ để thay thế.\n";
            }
        }
    }
}

echo "--- HOÀN TẤT CẬP NHẬT! ---\n";
?>
