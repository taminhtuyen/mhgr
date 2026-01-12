<?php

use Illuminate\Support\Facades\Route;

// --- IMPORT CONTROLLERS ---
use App\Http\Controllers\Admin\DashboardController;
// Sales
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\DeliveryController;
use App\Http\Controllers\Admin\ReturnController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\CartController;
// Catalog
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\ReviewController;
// Inventory
use App\Http\Controllers\Admin\InventoryStockController;
use App\Http\Controllers\Admin\WarehouseController;
use App\Http\Controllers\Admin\PurchaseOrderController;
use App\Http\Controllers\Admin\InventoryTransactionController;
// Finance
use App\Http\Controllers\Admin\ProfitDistributionController;
use App\Http\Controllers\Admin\WalletController;
use App\Http\Controllers\Admin\CommissionController;
// Consignment
use App\Http\Controllers\Admin\ConsignmentController;
use App\Http\Controllers\Admin\ConsignmentCustomerController;
// Marketing
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\FlashSaleController;
use App\Http\Controllers\Admin\AffiliateController;
// Content
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\GameSubjectController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ImageController;
// CRM
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\RequestController;
// System
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\SystemLogController;

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (STANDARD DESIGN)
|--------------------------------------------------------------------------
| Quy tắc đặt tên: admin.[nhóm].[chức_năng].[hành_động]
| Ví dụ: admin.sales.orders.index
*/

// Dashboard (Không thuộc nhóm nào)
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// 1. NHÓM BÁN HÀNG (Sales)
// URL: /admin/sales/... | Name: admin.sales....
Route::prefix('sales')->name('sales.')->group(function () {
    Route::resource('orders', OrderController::class);
    Route::resource('deliveries', DeliveryController::class);
    Route::resource('returns', ReturnController::class);
    Route::resource('invoices', InvoiceController::class);
    Route::resource('carts', CartController::class);
});

// 2. NHÓM SẢN PHẨM (Catalog)
// URL: /admin/catalog/... | Name: admin.catalog....
Route::prefix('catalog')->name('catalog.')->group(function () {
    Route::get('products', function () {
        return view('admin.products.index');
    })->name('products.index');
    Route::resource('categories', CategoryController::class);
    Route::resource('attributes', AttributeController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('reviews', ReviewController::class);
});

// 3. NHÓM KHO HÀNG (Inventory)
// URL: /admin/inventory/... | Name: admin.inventory....
Route::prefix('inventory')->name('inventory.')->group(function () {
    Route::resource('stocks', InventoryStockController::class);
    Route::resource('warehouses', WarehouseController::class);
    Route::resource('purchase-orders', PurchaseOrderController::class);
    Route::resource('transactions', InventoryTransactionController::class);
});

// 4. NHÓM TÀI CHÍNH (Finance)
// URL: /admin/finance/... | Name: admin.finance....
Route::prefix('finance')->name('finance.')->group(function () {
    Route::resource('profits', ProfitDistributionController::class);
    Route::resource('wallets', WalletController::class);
    Route::resource('commissions', CommissionController::class);
});

// 5. NHÓM KÝ GỬI (Consignment)
// URL: /admin/consignment/... | Name: admin.consignment....
Route::prefix('consignment')->name('consignment.')->group(function () {
    Route::resource('orders', ConsignmentController::class); // Đặt tên resource là 'orders' cho ngắn gọn trong nhóm này
    Route::resource('customers', ConsignmentCustomerController::class);
});

// 6. NHÓM MARKETING (Marketing)
// URL: /admin/marketing/... | Name: admin.marketing....
Route::prefix('marketing')->name('marketing.')->group(function () {
    Route::resource('promotions', PromotionController::class);
    Route::resource('coupons', CouponController::class);
    Route::resource('flash-sales', FlashSaleController::class);
    Route::resource('affiliates', AffiliateController::class);
});

// 7. NHÓM NỘI DUNG (Content)
// URL: /admin/content/... | Name: admin.content....
Route::prefix('content')->name('content.')->group(function () {
    Route::resource('posts', PostController::class);
    Route::resource('banners', BannerController::class);
    Route::resource('menus', MenuController::class);
    Route::resource('pages', PageController::class);
    Route::resource('images', ImageController::class);
    Route::resource('game-subjects', GameSubjectController::class);
});

// 8. NHÓM CRM (CRM)
// URL: /admin/crm/... | Name: admin.crm....
Route::prefix('crm')->name('crm.')->group(function () {
    Route::resource('customers', CustomerController::class);
    Route::resource('chats', ChatController::class);
    Route::resource('requests', RequestController::class);
});

// 9. NHÓM HỆ THỐNG (System)
// URL: /admin/system/... | Name: admin.system....
Route::prefix('system')->name('system.')->group(function () {
    Route::resource('settings', SettingController::class);
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('locations', LocationController::class);
    Route::resource('logs', SystemLogController::class);
});
