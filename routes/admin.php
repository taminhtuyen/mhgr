<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| IMPORT CONTROLLERS (KHAI BÁO CÁC FILE XỬ LÝ)
|--------------------------------------------------------------------------
*/

// 1. Dashboard
use App\Http\Controllers\Admin\DashboardController;

// 2. Nhóm Bán Hàng (Sales)
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\DeliveryController;
use App\Http\Controllers\Admin\ReturnController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\CartController;

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

// 8. Nhóm Nội Dung & Giao diện (Content & Appearance)
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\GameSubjectController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ImageController;

// 9. Nhóm CRM (Khách hàng)
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\RequestController;

// 10. Nhóm Hệ Thống (System)
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\SystemLogController;

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (CẤU HÌNH MENU)
|--------------------------------------------------------------------------
| Lưu ý: Sử dụng Route::resource để tự động tạo đủ các chức năng:
| Xem (index), Thêm (create/store), Sửa (edit/update), Xóa (destroy)
*/

// --- DASHBOARD ---
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');


// --- 1. NHÓM BÁN HÀNG ---
Route::prefix('sales')->group(function () {
    Route::resource('orders', OrderController::class);
    Route::resource('deliveries', DeliveryController::class);
    Route::resource('returns', ReturnController::class);
    Route::resource('invoices', InvoiceController::class);
    Route::resource('carts', CartController::class); // [MỚI] Giỏ hàng treo
});


// --- 2. NHÓM SẢN PHẨM ---
Route::prefix('catalog')->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('attributes', AttributeController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('reviews', ReviewController::class);
});


// --- 3. NHÓM KHO HÀNG ---
Route::prefix('inventory')->group(function () {
    Route::resource('stocks', InventoryStockController::class);
    Route::resource('warehouses', WarehouseController::class);
    Route::resource('purchase-orders', PurchaseOrderController::class);
    Route::resource('transactions', InventoryTransactionController::class);
});


// --- 4. NHÓM TÀI CHÍNH ---
Route::prefix('finance')->group(function () {
    // Đổi tên route distribution-rules thành profits cho ngắn gọn
    Route::resource('profits', ProfitDistributionController::class);
    Route::resource('wallets', WalletController::class);
    Route::resource('commissions', CommissionController::class);
});


// --- 5. NHÓM KÝ GỬI ---
Route::prefix('consignment')->group(function () {
    Route::resource('consignments', ConsignmentController::class);
    Route::resource('customers', ConsignmentCustomerController::class)->names('consignment_customers');
});


// --- 6. NHÓM MARKETING ---
Route::prefix('marketing')->group(function () {
    Route::resource('promotions', PromotionController::class);
    Route::resource('coupons', CouponController::class);
    Route::resource('flash-sales', FlashSaleController::class);
    Route::resource('affiliates', AffiliateController::class);
});


// --- 7. NHÓM NỘI DUNG & GIAO DIỆN ---
Route::prefix('content')->group(function () {
    Route::resource('posts', PostController::class);
    Route::resource('banners', BannerController::class);
    Route::resource('game-subjects', GameSubjectController::class);

    // Các phần mới bổ sung
    Route::resource('menus', MenuController::class);
    Route::resource('pages', PageController::class);
    Route::resource('images', ImageController::class);
});


// --- 8. NHÓM CRM ---
Route::prefix('crm')->group(function () {
    Route::resource('customers', CustomerController::class);
    Route::resource('chats', ChatController::class);
    Route::resource('requests', RequestController::class);
});


// --- 9. NHÓM HỆ THỐNG ---
Route::prefix('system')->group(function () {
    Route::resource('settings', SettingController::class);
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('locations', LocationController::class);
    Route::resource('logs', SystemLogController::class);
});
