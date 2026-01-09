<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| IMPORT CONTROLLERS
|--------------------------------------------------------------------------
*/

// 1. Dashboard
use App\Http\Controllers\Admin\DashboardController;

// 2. Nhóm Bán Hàng (Sales)
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\DeliveryController;
use App\Http\Controllers\Admin\ReturnController;
use App\Http\Controllers\Admin\InvoiceController;

// 3. Nhóm Sản Phẩm (Catalog)
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\ReviewController;

// 4. Nhóm Kho (Inventory)
use App\Http\Controllers\Admin\InventoryStockController;
use App\Http\Controllers\Admin\WarehouseController;
use App\Http\Controllers\Admin\PurchaseOrderController;
use App\Http\Controllers\Admin\InventoryTransactionController;

// 5. Nhóm Tài Chính (Finance)
use App\Http\Controllers\Admin\ProfitDistributionController;
use App\Http\Controllers\Admin\WalletController;
use App\Http\Controllers\Admin\CommissionController;

// 6. Nhóm Ký Gửi (Consignment)
use App\Http\Controllers\Admin\ConsignmentController;
use App\Http\Controllers\Admin\ConsignmentCustomerController;

// 7. Nhóm Marketing
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\FlashSaleController;
use App\Http\Controllers\Admin\AffiliateController;

// 8. Nhóm Nội Dung & Game (Content)
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\GameSubjectController;

// 9. Nhóm CRM
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ChatController;

// 10. Nhóm Hệ Thống (System)
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\SystemLogController;

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

// --- DASHBOARD ---
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');


// --- 1. NHÓM BÁN HÀNG ---
Route::prefix('sales')->group(function () {
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('deliveries', [DeliveryController::class, 'index'])->name('deliveries.index');
    Route::get('returns', [ReturnController::class, 'index'])->name('returns.index');
    Route::get('invoices', [InvoiceController::class, 'index'])->name('invoices.index');
});


// --- 2. NHÓM SẢN PHẨM ---
Route::prefix('catalog')->group(function () {
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('attributes', [AttributeController::class, 'index'])->name('attributes.index');
    Route::get('suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::get('reviews', [ReviewController::class, 'index'])->name('reviews.index');
});


// --- 3. NHÓM KHO HÀNG ---
Route::prefix('inventory')->group(function () {
    Route::get('stocks', [InventoryStockController::class, 'index'])->name('stocks.index');
    Route::get('warehouses', [WarehouseController::class, 'index'])->name('warehouses.index');
    Route::get('purchase-orders', [PurchaseOrderController::class, 'index'])->name('purchase_orders.index');
    // Mới: Xem lịch sử biến động kho
    Route::get('transactions', [InventoryTransactionController::class, 'index'])->name('inventory.transactions.index');
});


// --- 4. NHÓM TÀI CHÍNH (MỚI) ---
Route::prefix('finance')->group(function () {
    Route::get('distribution-rules', [ProfitDistributionController::class, 'index'])->name('finance.distribution.index');
    Route::get('wallets', [WalletController::class, 'index'])->name('finance.wallets.index');
    Route::get('commissions', [CommissionController::class, 'index'])->name('finance.commissions.index');
});


// --- 5. NHÓM KÝ GỬI ---
Route::prefix('consignment')->group(function () {
    Route::get('orders', [ConsignmentController::class, 'index'])->name('consignment.orders.index');
    Route::get('customers', [ConsignmentCustomerController::class, 'index'])->name('consignment.customers.index');
});


// --- 6. NHÓM MARKETING ---
Route::prefix('marketing')->group(function () {
    Route::get('campaigns', [PromotionController::class, 'index'])->name('promotions.index');
    Route::get('coupons', [CouponController::class, 'index'])->name('coupons.index');
    Route::get('flash-sales', [FlashSaleController::class, 'index'])->name('flash_sales.index');
    Route::get('affiliate', [AffiliateController::class, 'index'])->name('affiliate.index');
});


// --- 7. NHÓM NỘI DUNG & GAME (MỚI) ---
Route::prefix('content')->group(function () {
    Route::get('posts', [PostController::class, 'index'])->name('content.posts.index');
    Route::get('banners', [BannerController::class, 'index'])->name('content.banners.index');
    Route::get('game-subjects', [GameSubjectController::class, 'index'])->name('content.game_subjects.index');
});


// --- 8. NHÓM CRM ---
Route::prefix('crm')->group(function () {
    Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('chat', [ChatController::class, 'index'])->name('chat.index');
});


// --- 9. NHÓM HỆ THỐNG ---
Route::prefix('system')->group(function () {
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('locations', [LocationController::class, 'index'])->name('locations.index');
    Route::get('logs', [SystemLogController::class, 'index'])->name('system.logs.index');
});
