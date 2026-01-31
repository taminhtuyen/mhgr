<?php

use Illuminate\Support\Facades\Route;
use App\Events\SystemNotification;

// --- IMPORT CONTROLLERS (CẤU TRÚC MỚI SAU REFACTOR) ---

// 0. Dashboard
use App\Http\Controllers\Admin\Dashboard\DashboardController;

// 1. Sales (Bán Hàng)
use App\Http\Controllers\Admin\Sales\OrderController;
use App\Http\Controllers\Admin\Sales\ShippingShipmentController;
use App\Http\Controllers\Admin\Sales\OrderReturnController;
use App\Http\Controllers\Admin\Sales\TaxInvoiceController;
use App\Http\Controllers\Admin\Sales\CartController;

// 2. Catalog (Sản Phẩm)
use App\Http\Controllers\Admin\Catalog\ProductController;
use App\Http\Controllers\Admin\Catalog\CategoryController;
use App\Http\Controllers\Admin\Catalog\AttributeController;
use App\Http\Controllers\Admin\Catalog\SupplierController;
use App\Http\Controllers\Admin\Catalog\ProductReviewController;
use App\Http\Controllers\Admin\Catalog\PriceGroupController; // [MỚI]

// 3. Inventory (Kho Hàng)
use App\Http\Controllers\Admin\Inventory\InventoryStockController;
use App\Http\Controllers\Admin\Inventory\WarehouseController;
use App\Http\Controllers\Admin\Inventory\ImportOrderController;
use App\Http\Controllers\Admin\Inventory\InventoryTransactionController;
use App\Http\Controllers\Admin\Inventory\InventorySnapshotController; // [MỚI]

// 4. Logistics (Vận Tải - [MỚI])
use App\Http\Controllers\Admin\Logistics\ShippingPartnerController;
use App\Http\Controllers\Admin\Logistics\ShippingDriverController;
use App\Http\Controllers\Admin\Logistics\ShippingRateController;
use App\Http\Controllers\Admin\Logistics\DeliveryTripController;

// 5. Finance (Tài Chính)
use App\Http\Controllers\Admin\Finance\ProfitDistributionGroupController;
use App\Http\Controllers\Admin\Finance\RewardWalletController;
use App\Http\Controllers\Admin\Finance\CommissionController;

// 6. Consignment (Ký Gửi)
use App\Http\Controllers\Admin\Consignment\ConsignmentController;
use App\Http\Controllers\Admin\Consignment\ConsignmentCustomerController;

// 7. Marketing (Tiếp Thị)
use App\Http\Controllers\Admin\Marketing\PromotionController;
use App\Http\Controllers\Admin\Marketing\PromotionCouponController;
use App\Http\Controllers\Admin\Marketing\FlashSaleController;
use App\Http\Controllers\Admin\Marketing\AffiliateLinkController;
use App\Http\Controllers\Admin\Marketing\WishlistController; // [MỚI]

// 8. Content (Nội Dung)
use App\Http\Controllers\Admin\Content\PostController;
use App\Http\Controllers\Admin\Content\BannerController;
use App\Http\Controllers\Admin\Content\MenuController;
use App\Http\Controllers\Admin\Content\ImageController;
use App\Http\Controllers\Admin\Content\GameSubjectController;

// 9. CRM (Khách Hàng)
use App\Http\Controllers\Admin\CRM\CustomerController;
use App\Http\Controllers\Admin\CRM\ChatConversationController;
use App\Http\Controllers\Admin\CRM\CustomerRequestController;

// 10. System (Hệ Thống)
use App\Http\Controllers\Admin\System\SettingController;
use App\Http\Controllers\Admin\System\UserController;
use App\Http\Controllers\Admin\System\RoleController;
use App\Http\Controllers\Admin\System\LocationController;
use App\Http\Controllers\Admin\System\SystemLogController;
use App\Http\Controllers\Admin\System\TaxClassController; // [MỚI]
use App\Http\Controllers\Admin\System\BookingStatusController; // [MỚI]

// --- ROUTES ---

// [QUAN TRỌNG] Route chuyển hướng: /admin -> /admin/dashboard
Route::redirect('/', '/admin/dashboard');

// Dashboard Route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// 1. NHÓM SALES (Bán Hàng)
Route::prefix('sales')->name('sales.')->group(function () {
    Route::resource('orders', OrderController::class);
    Route::resource('shipping-shipments', ShippingShipmentController::class);
    Route::resource('returns', OrderReturnController::class);
    Route::resource('tax-invoices', TaxInvoiceController::class);
    Route::resource('carts', CartController::class);
});

// 2. NHÓM CATALOG (Sản Phẩm)
Route::prefix('catalog')->name('catalog.')->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('attributes', AttributeController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('product-reviews', ProductReviewController::class);
    Route::resource('price-groups', PriceGroupController::class); // [MỚI]
});

// 3. NHÓM INVENTORY (Kho Hàng)
Route::prefix('inventory')->name('inventory.')->group(function () {
    Route::resource('stocks', InventoryStockController::class);
    Route::resource('warehouses', WarehouseController::class);
    Route::resource('import-orders', ImportOrderController::class);
    Route::resource('transactions', InventoryTransactionController::class);
    Route::resource('snapshots', InventorySnapshotController::class); // [MỚI]
});

// 4. NHÓM LOGISTICS (Vận Tải - [MỚI])
Route::prefix('logistics')->name('logistics.')->group(function () {
    Route::resource('shipping-partners', ShippingPartnerController::class);
    Route::resource('drivers', ShippingDriverController::class);
    Route::resource('rates', ShippingRateController::class);
    Route::resource('trips', DeliveryTripController::class);
});

// 5. NHÓM FINANCE (Tài Chính)
Route::prefix('finance')->name('finance.')->group(function () {
    Route::resource('profit-distribution-groups', ProfitDistributionGroupController::class);
    Route::resource('reward-wallets', RewardWalletController::class);
    Route::resource('commissions', CommissionController::class);
});

// 6. NHÓM CONSIGNMENT (Ký Gửi)
Route::prefix('consignment')->name('consignment.')->group(function () {
    Route::resource('consignments', ConsignmentController::class);
    Route::resource('customers', ConsignmentCustomerController::class);
});

// 7. NHÓM MARKETING (Tiếp Thị)
Route::prefix('marketing')->name('marketing.')->group(function () {
    Route::resource('promotions', PromotionController::class);
    Route::resource('promotion-coupons', PromotionCouponController::class);
    Route::resource('flash-sales', FlashSaleController::class);
    Route::resource('affiliate-links', AffiliateLinkController::class);
    Route::resource('wishlists', WishlistController::class); // [MỚI]
});

// 8. NHÓM CONTENT (Nội Dung)
Route::prefix('content')->name('content.')->group(function () {
    Route::resource('posts', PostController::class);
    Route::resource('banners', BannerController::class);
    Route::resource('menus', MenuController::class);
    Route::resource('images', ImageController::class);
    Route::resource('game-subjects', GameSubjectController::class);
});

// 9. NHÓM CRM (Khách Hàng)
Route::prefix('crm')->name('crm.')->group(function () {
    Route::resource('customers', CustomerController::class);
    Route::resource('chat-conversations', ChatConversationController::class);
    Route::resource('requests', CustomerRequestController::class);
});

// 10. NHÓM SYSTEM (Hệ Thống)
Route::prefix('system')->name('system.')->group(function () {
    Route::resource('settings', SettingController::class);
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('locations', LocationController::class);
    Route::resource('logs', SystemLogController::class);
    Route::resource('tax-classes', TaxClassController::class); // [MỚI]
    Route::resource('booking-status', BookingStatusController::class); // [MỚI]
});

// --- TOOLS & UTILITIES (TESTING) ---
// 1. Test thông báo lỗi (Alert Style)
Route::get('/test-html-error', function () {
    event(new SystemNotification([
        'title'   => 'Cảnh báo Bảo mật',
        'type'    => 'error',
        'content' => 'Phát hiện truy cập trái phép từ IP lạ.<br>
                      <small class="text-muted">Vui lòng kiểm tra log ngay lập tức.</small>',
        'buttons' => [
            [
                'text'   => 'Đóng',
                'color'  => 'primary',
                'action' => ['type' => 'dismiss']
            ],
            [
                'text'   => 'Xem Log',
                'color'  => 'danger',
                'isBold' => true,
                'action' => ['type' => 'url', 'value' => '/admin/system/logs']
            ]
        ]
    ]));
    return "Đã gửi thông báo lỗi chuẩn iOS!";
});

// 2. Test thông báo xác nhận (Confirmation Style)
Route::get('/test-confirm-action', function () {
    event(new SystemNotification([
        'title'   => 'Xác nhận xóa?',
        'content' => 'Bạn có chắc chắn muốn xóa danh mục <b>"Điện tử"</b> không?<br>Hành động này không thể hoàn tác.',
        'type'    => 'warning',
        'buttons' => [
            [
                'text'   => 'Hủy bỏ',
                'color'  => 'primary',
                'action' => ['type' => 'dismiss']
            ],
            [
                'text'   => 'Xóa ngay',
                'color'  => 'danger',
                'isBold' => true,
                'action' => ['type' => 'livewire', 'value' => 'deleteCategory', 'params' => ['id' => 5]]
            ]
        ]
    ]));
    return "Đã gửi thông báo xác nhận chuẩn iOS!";
});

// 3. Test thông báo thành công (Simple Alert)
Route::get('/test-simple-success', function () {
    event(new SystemNotification([
        'title'   => 'Thành công',
        'content' => 'Cập nhật cài đặt hệ thống hoàn tất.',
        'type'    => 'success',
    ]));
    return "Đã gửi thông báo thành công chuẩn iOS!";
});
