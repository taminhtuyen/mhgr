<div class="popup-header d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
    <div class="h5 mb-0 fw-bold" style="color: var(--text-color);">
        <i class="fa-solid fa-bars-staggered me-2"></i>MENU QUẢN TRỊ
    </div>

    {{-- SWITCH BUTTON NGÀY ĐÊM --}}
    <div class="theme-switch-wrapper">
        <label for="theme" class="theme">
            <span class="theme__toggle-wrap">
                <input id="theme" class="theme__toggle" type="checkbox" role="switch" name="theme" value="dark">
                <span class="theme__icon">
                    <span class="theme__icon-part"></span>
                    <span class="theme__icon-part"></span>
                    <span class="theme__icon-part"></span>
                    <span class="theme__icon-part"></span>
                    <span class="theme__icon-part"></span>
                    <span class="theme__icon-part"></span>
                    <span class="theme__icon-part"></span>
                    <span class="theme__icon-part"></span>
                    <span class="theme__icon-part"></span>
                </span>
            </span>
        </label>
    </div>
</div>

<div class="popup-grid">
    {{-- CỘT 1: TỔNG QUAN & BÁN HÀNG & HỆ THỐNG --}}
    <div class="menu-column">
        <div class="group-title text-primary">TỔNG QUAN</div>
        <a href="{{ route('admin.dashboard') }}" class="menu-link"><i class="fa-solid fa-gauge"></i> Tổng Quan</a>

        <div class="group-title text-success group-spacer">BÁN HÀNG</div>
        <a href="{{ route('admin.sales.orders.index') }}" class="menu-link"><i class="fa-solid fa-cart-shopping"></i> Đơn Hàng</a>
        <a href="{{ route('admin.sales.deliveries.index') }}" class="menu-link"><i class="fa-solid fa-truck"></i> Vận Chuyển</a>
        <a href="{{ route('admin.sales.returns.index') }}" class="menu-link"><i class="fa-solid fa-rotate-left"></i> Trả Hàng</a>
        <a href="{{ route('admin.sales.invoices.index') }}" class="menu-link"><i class="fa-solid fa-file-invoice"></i> Hóa Đơn</a>
        <a href="{{ route('admin.sales.carts.index') }}" class="menu-link"><i class="fa-solid fa-cart-arrow-down"></i> Giỏ Hàng Treo</a>

        <div class="group-title text-dark group-spacer">HỆ THỐNG</div>
        <a href="{{ route('admin.system.settings.index') }}" class="menu-link"><i class="fa-solid fa-gear"></i> Cài Đặt</a>
        <a href="{{ route('admin.system.users.index') }}" class="menu-link"><i class="fa-solid fa-user-shield"></i> Quản Trị Viên</a>
        <a href="{{ route('admin.system.roles.index') }}" class="menu-link"><i class="fa-solid fa-user-lock"></i> Phân Quyền</a>
        <a href="{{ route('admin.system.locations.index') }}" class="menu-link"><i class="fa-solid fa-map-location-dot"></i> Vị Trí</a>
        <a href="{{ route('admin.system.logs.index') }}" class="menu-link"><i class="fa-solid fa-terminal"></i> Logs</a>
    </div>

    {{-- CỘT 2: SẢN PHẨM & KHO --}}
    <div class="menu-column">
        <div class="group-title text-warning">SẢN PHẨM</div>
        <a href="{{ route('admin.catalog.products.index') }}" class="menu-link"><i class="fa-solid fa-box-open"></i> Danh Sách SP</a>
        <a href="{{ route('admin.catalog.categories.index') }}" class="menu-link"><i class="fa-solid fa-layer-group"></i> Danh Mục</a>
        <a href="{{ route('admin.catalog.attributes.index') }}" class="menu-link"><i class="fa-solid fa-tags"></i> Thuộc Tính</a>
        <a href="{{ route('admin.catalog.suppliers.index') }}" class="menu-link"><i class="fa-solid fa-handshake"></i> Nhà Cung Cấp</a>
        <a href="{{ route('admin.catalog.reviews.index') }}" class="menu-link"><i class="fa-solid fa-star"></i> Đánh Giá</a>

        <div class="group-title text-danger group-spacer">KHO HÀNG</div>
        <a href="{{ route('admin.inventory.stocks.index') }}" class="menu-link"><i class="fa-solid fa-cubes"></i> Tồn Kho</a>
        <a href="{{ route('admin.inventory.warehouses.index') }}" class="menu-link"><i class="fa-solid fa-warehouse"></i> Danh Sách Kho</a>
        <a href="{{ route('admin.inventory.purchase-orders.index') }}" class="menu-link"><i class="fa-solid fa-file-import"></i> Nhập Hàng (PO)</a>
        <a href="{{ route('admin.inventory.transactions.index') }}" class="menu-link"><i class="fa-solid fa-clock-rotate-left"></i> Lịch Sử Kho</a>
    </div>

    {{-- CỘT 3: TÀI CHÍNH & KÝ GỬI & MARKETING --}}
    <div class="menu-column">
        <div class="group-title text-primary">TÀI CHÍNH</div>
        <a href="{{ route('admin.finance.profits.index') }}" class="menu-link"><i class="fa-solid fa-percent"></i> Chia Lợi Nhuận</a>
        <a href="{{ route('admin.finance.wallets.index') }}" class="menu-link"><i class="fa-solid fa-wallet"></i> Ví Tiền</a>
        <a href="{{ route('admin.finance.commissions.index') }}" class="menu-link"><i class="fa-solid fa-money-bill-transfer"></i> Hoa Hồng</a>

        <div class="group-title text-secondary group-spacer">KÝ GỬI</div>
        <a href="{{ route('admin.consignment.orders.index') }}" class="menu-link"><i class="fa-solid fa-clipboard-list"></i> Đơn Ký Gửi</a>
        <a href="{{ route('admin.consignment.customers.index') }}" class="menu-link"><i class="fa-solid fa-users-rectangle"></i> Khách Ký Gửi</a>

        <div class="group-title text-info group-spacer">MARKETING</div>
        <a href="{{ route('admin.marketing.promotions.index') }}" class="menu-link"><i class="fa-solid fa-bullhorn"></i> Chiến Dịch</a>
        <a href="{{ route('admin.marketing.coupons.index') }}" class="menu-link"><i class="fa-solid fa-ticket"></i> Mã Giảm Giá</a>
        <a href="{{ route('admin.marketing.flash-sales.index') }}" class="menu-link"><i class="fa-solid fa-bolt"></i> Flash Sale</a>
        <a href="{{ route('admin.marketing.affiliates.index') }}" class="menu-link"><i class="fa-solid fa-network-wired"></i> Affiliate</a>
    </div>

    {{-- CỘT 4: NỘI DUNG & CRM --}}
    <div class="menu-column">
        <div class="group-title text-secondary">NỘI DUNG</div>
        <a href="{{ route('admin.content.posts.index') }}" class="menu-link"><i class="fa-solid fa-newspaper"></i> Tin Tức</a>
        <a href="{{ route('admin.content.banners.index') }}" class="menu-link"><i class="fa-solid fa-image"></i> Banner</a>
        <a href="{{ route('admin.content.menus.index') }}" class="menu-link"><i class="fa-solid fa-bars"></i> Menu Web</a>
        <a href="{{ route('admin.content.pages.index') }}" class="menu-link"><i class="fa-solid fa-file-lines"></i> Trang Tĩnh</a>
        <a href="{{ route('admin.content.images.index') }}" class="menu-link"><i class="fa-solid fa-images"></i> Thư Viện Ảnh</a>
        <a href="{{ route('admin.content.game-subjects.index') }}" class="menu-link"><i class="fa-solid fa-gamepad"></i> Game / Học Tập</a>

        <div class="group-title text-warning group-spacer">CRM (KHÁCH HÀNG)</div>
        <a href="{{ route('admin.crm.customers.index') }}" class="menu-link"><i class="fa-solid fa-user-group"></i> Khách Hàng</a>
        <a href="{{ route('admin.crm.chats.index') }}" class="menu-link"><i class="fa-solid fa-comments"></i> Hội Thoại</a>
        <a href="{{ route('admin.crm.requests.index') }}" class="menu-link"><i class="fa-solid fa-envelope-open-text"></i> Yêu Cầu & Góp Ý</a>
    </div>
</div>
