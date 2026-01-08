<?php

use Illuminate\Support\Facades\Route;

// Import các Controller (Nhóm Bán Hàng)
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\DeliveryController;
use App\Http\Controllers\Admin\ReturnController;
use App\Http\Controllers\Admin\InvoiceController;

// Import các Controller (Nhóm Sản Phẩm - Sẽ tạo ở bước sau)
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\ReviewController;

// Import các Controller (Nhóm Kho - Sẽ tạo ở bước sau)
use App\Http\Controllers\Admin\InventoryStockController;
use App\Http\Controllers\Admin\WarehouseController;
use App\Http\Controllers\Admin\PurchaseOrderController;

// Import các Controller (Nhóm Ký Gửi - Sẽ tạo ở bước sau)
use App\Http\Controllers\Admin\ConsignmentController;
use App\Http\Controllers\Admin\ConsignmentCustomerController;

// Import các Controller (Nhóm Marketing - Sẽ tạo ở bước sau)
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\FlashSaleController;
use App\Http\Controllers\Admin\AffiliateController;

// Import các Controller (Nhóm CRM - Sẽ tạo ở bước sau)
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ChatController;

// Import các Controller (Nhóm Hệ Thống - Sẽ tạo ở bước sau)
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\LocationController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

// --- NHÓM BÁN HÀNG ---
Route::prefix('sales')->group(function () {
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('deliveries', [DeliveryController::class, 'index'])->name('deliveries.index');
    Route::get('returns', [ReturnController::class, 'index'])->name('returns.index');
    Route::get('invoices', [InvoiceController::class, 'index'])->name('invoices.index');
});

// --- NHÓM SẢN PHẨM ---
Route::prefix('catalog')->group(function () {
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('attributes', [AttributeController::class, 'index'])->name('attributes.index');
    Route::get('suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::get('reviews', [ReviewController::class, 'index'])->name('reviews.index');
});

// --- NHÓM KHO HÀNG ---
Route::prefix('inventory')->group(function () {
    Route::get('stocks', [InventoryStockController::class, 'index'])->name('stocks.index');
    Route::get('warehouses', [WarehouseController::class, 'index'])->name('warehouses.index');
    Route::get('purchase-orders', [PurchaseOrderController::class, 'index'])->name('purchase_orders.index');
});

// --- NHÓM KÝ GỬI ---
Route::prefix('consignment')->group(function () {
    Route::get('orders', [ConsignmentController::class, 'index'])->name('consignment.orders.index');
    Route::get('customers', [ConsignmentCustomerController::class, 'index'])->name('consignment.customers.index');
});

// --- NHÓM MARKETING ---
Route::prefix('marketing')->group(function () {
    Route::get('campaigns', [PromotionController::class, 'index'])->name('promotions.index');
    Route::get('coupons', [CouponController::class, 'index'])->name('coupons.index');
    Route::get('flash-sales', [FlashSaleController::class, 'index'])->name('flash_sales.index');
    Route::get('affiliate', [AffiliateController::class, 'index'])->name('affiliate.index');
});

// --- NHÓM CRM ---
Route::prefix('crm')->group(function () {
    Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('chat', [ChatController::class, 'index'])->name('chat.index');
});

// --- NHÓM HỆ THỐNG ---
Route::prefix('system')->group(function () {
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('locations', [LocationController::class, 'index'])->name('locations.index');
});
