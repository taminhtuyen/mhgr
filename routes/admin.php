<?php

use Illuminate\Support\Facades\Route;
use App\Events\SystemNotification;

// --- IMPORT CONTROLLERS (CẤU TRÚC MỚI) ---

// 0. Dashboard
use App\Http\Controllers\Admin\Dashboard\DashboardController;

// 1. Sales (Bán Hàng)
use App\Http\Controllers\Admin\Sales\OrderController;
use App\Http\Controllers\Admin\Sales\DeliveryController;
use App\Http\Controllers\Admin\Sales\ReturnController;
use App\Http\Controllers\Admin\Sales\InvoiceController;
use App\Http\Controllers\Admin\Sales\CartController;

// 2. Catalog (Sản Phẩm)
use App\Http\Controllers\Admin\Catalog\ProductController;
use App\Http\Controllers\Admin\Catalog\CategoryController;
use App\Http\Controllers\Admin\Catalog\AttributeController;
use App\Http\Controllers\Admin\Catalog\SupplierController;
use App\Http\Controllers\Admin\Catalog\ReviewController;

// 3. Inventory (Kho Hàng)
use App\Http\Controllers\Admin\Inventory\InventoryStockController;
use App\Http\Controllers\Admin\Inventory\WarehouseController;
use App\Http\Controllers\Admin\Inventory\PurchaseOrderController;
use App\Http\Controllers\Admin\Inventory\InventoryTransactionController;

// 4. Finance (Tài Chính)
use App\Http\Controllers\Admin\Finance\ProfitDistributionController;
use App\Http\Controllers\Admin\Finance\WalletController;
use App\Http\Controllers\Admin\Finance\CommissionController;

// 5. Consignment (Ký Gửi)
use App\Http\Controllers\Admin\Consignment\ConsignmentController;
use App\Http\Controllers\Admin\Consignment\ConsignmentCustomerController;

// 6. Marketing (Marketing)
use App\Http\Controllers\Admin\Marketing\PromotionController;
use App\Http\Controllers\Admin\Marketing\CouponController;
use App\Http\Controllers\Admin\Marketing\FlashSaleController;
use App\Http\Controllers\Admin\Marketing\AffiliateController;

// 7. Content (Nội Dung)
use App\Http\Controllers\Admin\Content\PostController;
use App\Http\Controllers\Admin\Content\BannerController;
use App\Http\Controllers\Admin\Content\GameSubjectController;
use App\Http\Controllers\Admin\Content\MenuController;
use App\Http\Controllers\Admin\Content\PageController;
use App\Http\Controllers\Admin\Content\ImageController;

// 8. CRM (Khách Hàng & Chat)
use App\Http\Controllers\Admin\CRM\CustomerController;
use App\Http\Controllers\Admin\CRM\ChatController;
use App\Http\Controllers\Admin\CRM\RequestController;

// 9. System (Hệ Thống)
use App\Http\Controllers\Admin\System\SettingController;
use App\Http\Controllers\Admin\System\UserController;
use App\Http\Controllers\Admin\System\RoleController;
use App\Http\Controllers\Admin\System\LocationController;
use App\Http\Controllers\Admin\System\SystemLogController;

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (REFACTORED STRUCTURE)
|--------------------------------------------------------------------------
| Quy tắc đặt tên: admin.[nhóm].[chức_năng].[hành_động]
| Logic: Giữ nguyên luồng xử lý cũ, chỉ thay đổi Namespace Controller.
*/

// --- ROUTE TEST THÔNG BÁO REAL-TIME ---
Route::get('/test-notification', function () {
    $message = "Hệ thống: Có đơn hàng mới #MB" . rand(1000, 9999) . " vừa được tạo lúc " . date('H:i:s');
    event(new SystemNotification($message));
    return "<h1>Đã gửi thông báo: $message</h1><p>Hãy kiểm tra Tab Admin Dashboard.</p>";
});

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// 1. NHÓM BÁN HÀNG (Sales)
Route::prefix('sales')->name('sales.')->group(function () {
    Route::resource('orders', OrderController::class);
    Route::resource('deliveries', DeliveryController::class);
    Route::resource('returns', ReturnController::class);
    Route::resource('invoices', InvoiceController::class);
    Route::resource('carts', CartController::class);
});

// 2. NHÓM SẢN PHẨM (Catalog)
Route::prefix('catalog')->name('catalog.')->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('attributes', AttributeController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('reviews', ReviewController::class);
});

// 3. NHÓM KHO HÀNG (Inventory)
Route::prefix('inventory')->name('inventory.')->group(function () {
    Route::resource('stocks', InventoryStockController::class);
    Route::resource('warehouses', WarehouseController::class);
    Route::resource('purchase-orders', PurchaseOrderController::class);
    Route::resource('transactions', InventoryTransactionController::class);
});

// 4. NHÓM TÀI CHÍNH (Finance)
Route::prefix('finance')->name('finance.')->group(function () {
    Route::resource('profits', ProfitDistributionController::class);
    Route::resource('wallets', WalletController::class);
    Route::resource('commissions', CommissionController::class);
});

// 5. NHÓM KÝ GỬI (Consignment)
Route::prefix('consignment')->name('consignment.')->group(function () {
    Route::resource('orders', ConsignmentController::class);
    Route::resource('customers', ConsignmentCustomerController::class);
});

// 6. NHÓM MARKETING (Marketing)
Route::prefix('marketing')->name('marketing.')->group(function () {
    Route::resource('promotions', PromotionController::class);
    Route::resource('coupons', CouponController::class);
    Route::resource('flash-sales', FlashSaleController::class);
    Route::resource('affiliates', AffiliateController::class);
});

// 7. NHÓM NỘI DUNG (Content)
Route::prefix('content')->name('content.')->group(function () {
    Route::resource('posts', PostController::class);
    Route::resource('banners', BannerController::class);
    Route::resource('menus', MenuController::class);
    Route::resource('pages', PageController::class);
    Route::resource('images', ImageController::class);
    Route::resource('game-subjects', GameSubjectController::class);
});

// 8. NHÓM CRM (CRM)
Route::prefix('crm')->name('crm.')->group(function () {
    Route::resource('customers', CustomerController::class);
    Route::resource('chats', ChatController::class);
    Route::resource('requests', RequestController::class);
});

// 9. NHÓM HỆ THỐNG (System)
Route::prefix('system')->name('system.')->group(function () {
    Route::resource('settings', SettingController::class);
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('locations', LocationController::class);
    Route::resource('logs', SystemLogController::class);
});
