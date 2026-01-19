<?php

use Illuminate\Support\Facades\Route;
use App\Events\SystemNotification;

// --- IMPORT CONTROLLERS (CẤU TRÚC MỚI SAU REFACTOR) ---

// 0. Dashboard
use App\Http\Controllers\Admin\Dashboard\DashboardController;

// 1. Sales (Bán Hàng)
use App\Http\Controllers\Admin\Sales\OrderController;
use App\Http\Controllers\Admin\Sales\ShippingShipmentController; // Đã đổi từ DeliveryController
use App\Http\Controllers\Admin\Sales\ReturnController;
use App\Http\Controllers\Admin\Sales\TaxInvoiceController; // Đã đổi từ InvoiceController
use App\Http\Controllers\Admin\Sales\CartController;

// 2. Catalog (Sản Phẩm)
use App\Http\Controllers\Admin\Catalog\ProductController;
use App\Http\Controllers\Admin\Catalog\CategoryController;
use App\Http\Controllers\Admin\Catalog\AttributeController;
use App\Http\Controllers\Admin\Catalog\SupplierController;
use App\Http\Controllers\Admin\Catalog\ProductReviewController; // Đã đổi từ ReviewController

// 3. Inventory (Kho Hàng)
use App\Http\Controllers\Admin\Inventory\InventoryStockController;
use App\Http\Controllers\Admin\Inventory\WarehouseController;
use App\Http\Controllers\Admin\Inventory\ImportOrderController; // Đã đổi từ PurchaseOrderController
use App\Http\Controllers\Admin\Inventory\InventoryTransactionController;

// 4. Finance (Tài Chính)
use App\Http\Controllers\Admin\Finance\ProfitDistributionGroupController; // Đã đổi từ ProfitDistributionController
use App\Http\Controllers\Admin\Finance\RewardWalletController; // Đã đổi từ WalletController
use App\Http\Controllers\Admin\Finance\CommissionController;

// 5. Consignment (Ký Gửi)
use App\Http\Controllers\Admin\Consignment\ConsignmentController;
use App\Http\Controllers\Admin\Consignment\ConsignmentCustomerController;

// 6. Marketing (Tiếp Thị)
use App\Http\Controllers\Admin\Marketing\PromotionController;
use App\Http\Controllers\Admin\Marketing\PromotionCouponController; // Đã đổi từ CouponController
use App\Http\Controllers\Admin\Marketing\FlashSaleController;
use App\Http\Controllers\Admin\Marketing\AffiliateLinkController; // Đã đổi từ AffiliateController

// 7. Content (Nội Dung)
use App\Http\Controllers\Admin\Content\PostController;
use App\Http\Controllers\Admin\Content\BannerController;
use App\Http\Controllers\Admin\Content\MenuController;
use App\Http\Controllers\Admin\Content\ImageController;
use App\Http\Controllers\Admin\Content\GameSubjectController;
// Đã xóa PageController

// 8. CRM (Khách Hàng)
use App\Http\Controllers\Admin\CRM\CustomerController;
use App\Http\Controllers\Admin\CRM\ChatConversationController; // Đã đổi từ ChatController
use App\Http\Controllers\Admin\CRM\RequestController;

// 9. System (Hệ Thống)
use App\Http\Controllers\Admin\System\SettingController;
use App\Http\Controllers\Admin\System\UserController;
use App\Http\Controllers\Admin\System\RoleController;
use App\Http\Controllers\Admin\System\LocationController;
use App\Http\Controllers\Admin\System\SystemLogController;

// --- ROUTES ---

// [QUAN TRỌNG] Route chuyển hướng: /admin -> /admin/dashboard
// Giúp sửa lỗi 404 khi truy cập http://domain/admin
Route::redirect('/', '/admin/dashboard');

// Dashboard Route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// 1. NHÓM SALES (Bán Hàng)
Route::prefix('sales')->name('sales.')->group(function () {
    Route::resource('orders', OrderController::class);
    // URL chuẩn mới: shipping-shipments
    Route::resource('shipping-shipments', ShippingShipmentController::class);
    Route::resource('returns', ReturnController::class);
    // URL chuẩn mới: tax-invoices
    Route::resource('tax-invoices', TaxInvoiceController::class);
    Route::resource('carts', CartController::class);
});

// 2. NHÓM CATALOG (Sản Phẩm)
Route::prefix('catalog')->name('catalog.')->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('attributes', AttributeController::class);
    Route::resource('suppliers', SupplierController::class);
    // URL chuẩn mới: product-reviews
    Route::resource('product-reviews', ProductReviewController::class);
});

// 3. NHÓM INVENTORY (Kho Hàng)
Route::prefix('inventory')->name('inventory.')->group(function () {
    Route::resource('stocks', InventoryStockController::class);
    Route::resource('warehouses', WarehouseController::class);
    // URL chuẩn mới: import-orders
    Route::resource('import-orders', ImportOrderController::class);
    Route::resource('transactions', InventoryTransactionController::class);
});

// 4. NHÓM FINANCE (Tài Chính)
Route::prefix('finance')->name('finance.')->group(function () {
    // URL chuẩn mới: profit-distribution-groups
    Route::resource('profit-distribution-groups', ProfitDistributionGroupController::class);
    // URL chuẩn mới: reward-wallets
    Route::resource('reward-wallets', RewardWalletController::class);
    Route::resource('commissions', CommissionController::class);
});

// 5. NHÓM CONSIGNMENT (Ký Gửi)
Route::prefix('consignment')->name('consignment.')->group(function () {
    Route::resource('consignments', ConsignmentController::class);
    Route::resource('customers', ConsignmentCustomerController::class);
});

// 6. NHÓM MARKETING (Tiếp Thị)
Route::prefix('marketing')->name('marketing.')->group(function () {
    Route::resource('promotions', PromotionController::class);
    // URL chuẩn mới: promotion-coupons
    Route::resource('promotion-coupons', PromotionCouponController::class);
    Route::resource('flash-sales', FlashSaleController::class);
    // URL chuẩn mới: affiliate-links
    Route::resource('affiliate-links', AffiliateLinkController::class);
});

// 7. NHÓM CONTENT (Nội Dung)
Route::prefix('content')->name('content.')->group(function () {
    Route::resource('posts', PostController::class);
    Route::resource('banners', BannerController::class);
    Route::resource('menus', MenuController::class);
    Route::resource('images', ImageController::class);
    Route::resource('game-subjects', GameSubjectController::class);
});

// 8. NHÓM CRM (Khách Hàng)
Route::prefix('crm')->name('crm.')->group(function () {
    Route::resource('customers', CustomerController::class);
    // URL chuẩn mới: chat-conversations
    Route::resource('chat-conversations', ChatConversationController::class);
    Route::resource('requests', RequestController::class);
});

// 9. NHÓM SYSTEM (Hệ Thống)
Route::prefix('system')->name('system.')->group(function () {
    Route::resource('settings', SettingController::class);
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('locations', LocationController::class);
    Route::resource('logs', SystemLogController::class);
});
