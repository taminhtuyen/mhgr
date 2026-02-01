<script src="{{ asset('js/Sortable.min.js') }}"></script>

<div id="menu-interface" class="d-none">
    <style>
        /* --- BIẾN MÀU NEON --- */
        :root {
            --popup-border-highlight: rgba(0, 0, 0, 0.1);
            --neon-glow: var(--primary);
            --link-hover-bg: rgba(0, 0, 0, 0.03);
        }
        body.dark-mode {
            --popup-border-highlight: rgba(255, 255, 255, 0.1);
            --link-hover-bg: rgba(255, 255, 255, 0.05);
        }
        /* Colors per group */
        .menu-group-box[data-group-id="overview"]    { --neon-glow: #0d6efd; }
        .menu-group-box[data-group-id="sales"]       { --neon-glow: #198754; }
        .menu-group-box[data-group-id="logistics"]   { --neon-glow: #20c997; }
        .menu-group-box[data-group-id="system"]      { --neon-glow: #6c757d; }
        .menu-group-box[data-group-id="products"]    { --neon-glow: #ffc107; }
        .menu-group-box[data-group-id="inventory"]   { --neon-glow: #dc3545; }
        .menu-group-box[data-group-id="finance"]     { --neon-glow: #6610f2; }
        .menu-group-box[data-group-id="consignment"] { --neon-glow: #adb5bd; }
        .menu-group-box[data-group-id="marketing"]   { --neon-glow: #0dcaf0; }
        .menu-group-box[data-group-id="content"]     { --neon-glow: #6f42c1; }
        .menu-group-box[data-group-id="crm"]         { --neon-glow: #fd7e14; }

        .menu-link {
            display: flex; align-items: center; text-decoration: none !important; color: var(--text-color);
            border-radius: 0.625rem; font-weight: 500; font-size: 0.92rem; white-space: nowrap;
            /* TẮT CHẬM 2s */
            transition:
                background-color 0.25s ease,
                color 2s ease-out,
                text-shadow 2s ease-out,
                border-color 2s ease-out,
                box-shadow 2s ease-out;
        }

        /* NEON ACTIVE ON (0.5s) */
        body.neon-active .menu-link:hover span,
        body.neon-active .menu-link:hover i {
            color: #ffffff !important;
            text-shadow: 0 0 0.3125rem var(--neon-glow);
            transition: color 0.5s ease-out, text-shadow 0.5s ease-out;
        }

        body:not(.dark-mode).neon-active .menu-link:hover span,
        body:not(.dark-mode).neon-active .menu-link:hover i {
            color: var(--neon-glow) !important;
            text-shadow: none !important;
            transition: color 0.5s ease-out;
        }

        /* Khi đèn tắt */
        body:not(.neon-active) .menu-link:hover { background-color: var(--link-hover-bg); }

        /* LIST VIEW */
        .view-mode-list { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5625rem; }
        .view-mode-list .menu-items-container { display: flex; flex-direction: column; gap: 0.3125rem; }
        .view-mode-list .menu-link { padding: 0.5625rem 0.875rem; border: 0.0625rem solid transparent; }

        body.neon-active .view-mode-list .menu-link:hover {
            background-color: transparent !important; border-color: #ffffff !important;
            box-shadow: inset 0 0 0.3125rem var(--neon-glow), 0 0 0.3125rem var(--neon-glow), 0 0 0.9375rem var(--neon-glow);
            transform: none !important;
            transition: box-shadow 0.5s ease-out, border-color 0.5s ease-out;
        }

        .view-mode-list .menu-link i { width: 1.5rem; margin-right: 0.625rem; text-align: center; color: var(--text-muted); font-size: 1rem; }
        @media (max-width: 998px) { .view-mode-list { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 576px) { .view-mode-list { grid-template-columns: 1fr; } }

        /* GRID VIEW */
        .view-mode-grid .menu-items-container { display: flex; flex-wrap: wrap; gap: 0.9375rem; }
        .view-mode-grid .menu-group-box { width: 100%; margin-bottom: 1.5625rem; }
        .view-mode-grid .menu-link { flex-direction: column; justify-content: center; width: 5.75rem; height: 5.75rem; background: transparent; border: 0.0625rem solid var(--popup-border-highlight); border-radius: 0.75rem; padding: 0.75rem 0.3125rem; }

        body.neon-active .view-mode-grid .menu-link:hover {
            background-color: transparent !important; border-color: #ffffff !important;
            box-shadow: inset 0 0 0.3125rem var(--neon-glow), 0 0 0.3125rem var(--neon-glow), 0 0 0.9375rem var(--neon-glow);
            transform: none !important;
            transition: box-shadow 0.5s ease-out, border-color 0.5s ease-out;
        }

        .view-mode-grid .menu-link i { font-size: 1.75rem; margin-bottom: 0.625rem; color: var(--neon-glow); }
        .view-mode-grid .menu-link span { font-size: 0.75rem; font-weight: 700; line-height: 1.2; text-align: center; }

        /* SCROLL & HEADER */
        #menu-interface { width: 100%; overflow-y: auto; max-height: 80vh; scrollbar-width: thin; overscroll-behavior: contain; }
        #menu-interface::-webkit-scrollbar { width: 0.375rem; }
        #menu-interface::-webkit-scrollbar-thumb { background-color: var(--scrollbar-thumb); border-radius: 0.625rem; }
        .popup-header { padding: 1.125rem 1.5625rem; border-bottom: 0.0625rem solid var(--popup-border); position: sticky; top: 0; z-index: 50; background-color: var(--popup-bg); backdrop-filter: blur(0.625rem); -webkit-backdrop-filter: blur(0.625rem); margin-top: -0.0625rem; }
        .menu-main-wrapper { padding: 1.5625rem; }
        .group-title { font-size: 0.7rem; font-weight: 800; text-transform: uppercase; color: var(--text-muted); margin-bottom: 0.625rem; letter-spacing: 0.05rem; padding-bottom: 0.3125rem; border-bottom: 0.125rem solid rgba(0,0,0,0.03); }
        body.dark-mode .group-title { border-bottom-color: rgba(255,255,255,0.05); }
        .btn-close-popup { width: 2rem; height: 2rem; display: flex; align-items: center; justify-content: center; border-radius: 50%; transition: all 0.2s; color: var(--text-muted); }
        .btn-close-popup:hover { background-color: rgba(127,127,127,0.1); color: var(--text-color); }
    </style>

    <div class="popup-header d-flex justify-content-between align-items-center">
        <div class="h5 mb-0 fw-bold d-flex align-items-center" style="color: var(--text-color);">
            <i class="fa-solid fa-bars-staggered me-2 text-primary"></i>MENU
        </div>
        <button class="btn btn-sm btn-icon text-muted btn-close-popup bg-transparent border-0" onclick="closeAll()" title="Đóng">
            <i class="fa-solid fa-xmark" style="font-size: 1.2rem;"></i>
        </button>
    </div>

    {{-- CONTAINER CHÍNH --}}
    <div class="menu-main-wrapper view-mode-list" id="admin-menu-container">
        {{-- NHÓM 1: TỔNG QUAN --}}
        <div class="menu-group-box" data-group-id="overview">
            <div class="group-title text-primary">TỔNG QUAN</div>
            <div class="menu-items-container" data-sort-group="overview">
                <a href="{{ route('admin.dashboard') }}" class="menu-link neon-trigger" data-id="dashboard"><i class="fa-solid fa-gauge"></i> <span>Tổng Quan</span></a>
            </div>
        </div>

        {{-- NHÓM 2: BÁN HÀNG --}}
        <div class="menu-group-box" data-group-id="sales">
            <div class="group-title text-success">BÁN HÀNG</div>
            <div class="menu-items-container" data-sort-group="sales">
                <a href="{{ route('admin.sales.orders.index') }}" class="menu-link neon-trigger" data-id="orders"><i class="fa-solid fa-cart-shopping"></i> <span>Đơn Hàng</span></a>
                <a href="{{ route('admin.sales.shipping-shipments.index') }}" class="menu-link neon-trigger" data-id="deliveries"><i class="fa-solid fa-truck"></i> <span>Vận Chuyển</span></a>
                <a href="{{ route('admin.sales.returns.index') }}" class="menu-link neon-trigger" data-id="returns"><i class="fa-solid fa-rotate-left"></i> <span>Trả Hàng</span></a>
                <a href="{{ route('admin.sales.tax-invoices.index') }}" class="menu-link neon-trigger" data-id="invoices"><i class="fa-solid fa-file-invoice"></i> <span>Hóa Đơn</span></a>
                <a href="{{ route('admin.sales.carts.index') }}" class="menu-link neon-trigger" data-id="carts"><i class="fa-solid fa-cart-arrow-down"></i> <span>Giỏ Treo</span></a>
            </div>
        </div>

        {{-- NHÓM 3: LOGISTICS (VẬN TẢI - MỚI) --}}
        <div class="menu-group-box" data-group-id="logistics">
            <div class="group-title text-info" style="color: #20c997 !important;">VẬN TẢI (LOGISTICS)</div>
            <div class="menu-items-container" data-sort-group="logistics">
                <a href="{{ route('admin.logistics.shipping-partners.index') }}" class="menu-link neon-trigger" data-id="logistics_partners"><i class="fa-solid fa-handshake-simple"></i> <span>Đối Tác VC</span></a>
                <a href="{{ route('admin.logistics.drivers.index') }}" class="menu-link neon-trigger" data-id="logistics_drivers"><i class="fa-solid fa-id-card"></i> <span>Tài Xế</span></a>
                <a href="{{ route('admin.logistics.rates.index') }}" class="menu-link neon-trigger" data-id="logistics_rates"><i class="fa-solid fa-scale-balanced"></i> <span>Biểu Phí</span></a>
                <a href="{{ route('admin.logistics.trips.index') }}" class="menu-link neon-trigger" data-id="logistics_trips"><i class="fa-solid fa-route"></i> <span>Chuyến Giao</span></a>
            </div>
        </div>

        {{-- NHÓM 4: HỆ THỐNG --}}
        <div class="menu-group-box" data-group-id="system">
            <div class="group-title text-dark">HỆ THỐNG</div>
            <div class="menu-items-container" data-sort-group="system">
                <a href="{{ route('admin.system.settings.index') }}" class="menu-link neon-trigger" data-id="settings"><i class="fa-solid fa-gear"></i> <span>Cài Đặt</span></a>
                <a href="{{ route('admin.system.tax-classes.index') }}" class="menu-link neon-trigger" data-id="taxes"><i class="fa-solid fa-percent"></i> <span>Thuế & Phí</span></a>
                <a href="{{ route('admin.system.booking-status.index') }}" class="menu-link neon-trigger" data-id="booking_status"><i class="fa-solid fa-list-check"></i> <span>Quy Trình Đơn</span></a>

                <a href="{{ route('admin.system.users.index') }}" class="menu-link neon-trigger" data-id="users"><i class="fa-solid fa-user-shield"></i> <span>Quản Trị</span></a>
                <a href="{{ route('admin.system.roles.index') }}" class="menu-link neon-trigger" data-id="roles"><i class="fa-solid fa-user-lock"></i> <span>Phân Quyền</span></a>
                <a href="{{ route('admin.system.locations.index') }}" class="menu-link neon-trigger" data-id="locations"><i class="fa-solid fa-map-location-dot"></i> <span>Vị Trí</span></a>
                <a href="{{ route('admin.system.logs.index') }}" class="menu-link neon-trigger" data-id="logs"><i class="fa-solid fa-terminal"></i> <span>Logs</span></a>
            </div>
        </div>

        {{-- NHÓM 5: SẢN PHẨM --}}
        <div class="menu-group-box" data-group-id="products">
            <div class="group-title text-warning">SẢN PHẨM</div>
            <div class="menu-items-container" data-sort-group="products">
                <a href="{{ route('admin.catalog.products.index') }}" class="menu-link neon-trigger" data-id="products_list"><i class="fa-solid fa-box-open"></i> <span>Sản Phẩm</span></a>
                <a href="{{ route('admin.catalog.categories.index') }}" class="menu-link neon-trigger" data-id="categories"><i class="fa-solid fa-layer-group"></i> <span>Danh Mục</span></a>
                <a href="{{ route('admin.catalog.attributes.index') }}" class="menu-link neon-trigger" data-id="attributes"><i class="fa-solid fa-tags"></i> <span>Thuộc Tính</span></a>
                <a href="{{ route('admin.catalog.price-groups.index') }}" class="menu-link neon-trigger" data-id="price_groups"><i class="fa-solid fa-tag"></i> <span>Bảng Giá</span></a>
                <a href="{{ route('admin.catalog.suppliers.index') }}" class="menu-link neon-trigger" data-id="suppliers"><i class="fa-solid fa-dolly"></i> <span>Nhà Cung Cấp</span></a>
                <a href="{{ route('admin.catalog.product-reviews.index') }}" class="menu-link neon-trigger" data-id="reviews"><i class="fa-solid fa-star"></i> <span>Đánh Giá</span></a>
            </div>
        </div>

        {{-- NHÓM 6: KHO HÀNG --}}
        <div class="menu-group-box" data-group-id="inventory">
            <div class="group-title text-danger">KHO HÀNG</div>
            <div class="menu-items-container" data-sort-group="inventory">
                <a href="{{ route('admin.inventory.stocks.index') }}" class="menu-link neon-trigger" data-id="stocks"><i class="fa-solid fa-cubes"></i> <span>Tồn Kho</span></a>
                <a href="{{ route('admin.inventory.snapshots.index') }}" class="menu-link neon-trigger" data-id="snapshots"><i class="fa-solid fa-clipboard-check"></i> <span>Kiểm Kê</span></a>
                <a href="{{ route('admin.inventory.warehouses.index') }}" class="menu-link neon-trigger" data-id="warehouses"><i class="fa-solid fa-warehouse"></i> <span>Danh Sách Kho</span></a>
                <a href="{{ route('admin.inventory.import-orders.index') }}" class="menu-link neon-trigger" data-id="po"><i class="fa-solid fa-file-import"></i> <span>Nhập (PO)</span></a>
                <a href="{{ route('admin.inventory.transactions.index') }}" class="menu-link neon-trigger" data-id="transactions"><i class="fa-solid fa-clock-rotate-left"></i> <span>Lịch Sử Kho</span></a>
            </div>
        </div>

        {{-- NHÓM 7: TÀI CHÍNH --}}
        <div class="menu-group-box" data-group-id="finance">
            <div class="group-title text-primary">TÀI CHÍNH</div>
            <div class="menu-items-container" data-sort-group="finance">
                <a href="{{ route('admin.finance.profit-distribution-groups.index') }}" class="menu-link neon-trigger" data-id="profits"><i class="fa-solid fa-chart-pie"></i> <span>Lợi Nhuận</span></a>
                <a href="{{ route('admin.finance.reward-wallets.index') }}" class="menu-link neon-trigger" data-id="wallets"><i class="fa-solid fa-wallet"></i> <span>Ví Tiền</span></a>
                <a href="{{ route('admin.finance.commissions.index') }}" class="menu-link neon-trigger" data-id="commissions"><i class="fa-solid fa-money-bill-transfer"></i> <span>Hoa Hồng</span></a>
            </div>
        </div>

        {{-- NHÓM 8: KÝ GỬI --}}
        <div class="menu-group-box" data-group-id="consignment">
            <div class="group-title text-secondary">KÝ GỬI</div>
            <div class="menu-items-container" data-sort-group="consignment">
                <a href="{{ route('admin.consignment.consignments.index') }}" class="menu-link neon-trigger" data-id="consignment_orders"><i class="fa-solid fa-clipboard-list"></i> <span>Đơn Ký Gửi</span></a>
                <a href="{{ route('admin.consignment.customers.index') }}" class="menu-link neon-trigger" data-id="consignment_customers"><i class="fa-solid fa-users-rectangle"></i> <span>Khách Ký Gửi</span></a>
            </div>
        </div>

        {{-- NHÓM 9: MARKETING --}}
        <div class="menu-group-box" data-group-id="marketing">
            <div class="group-title text-info">MARKETING</div>
            <div class="menu-items-container" data-sort-group="marketing">
                <a href="{{ route('admin.marketing.promotions.index') }}" class="menu-link neon-trigger" data-id="promotions"><i class="fa-solid fa-bullhorn"></i> <span>Chiến Dịch</span></a>
                <a href="{{ route('admin.marketing.promotion-coupons.index') }}" class="menu-link neon-trigger" data-id="coupons"><i class="fa-solid fa-ticket"></i> <span>Voucher</span></a>
                <a href="{{ route('admin.marketing.flash-sales.index') }}" class="menu-link neon-trigger" data-id="flash"><i class="fa-solid fa-bolt"></i> <span>Flash Sale</span></a>
                <a href="{{ route('admin.marketing.affiliate-links.index') }}" class="menu-link neon-trigger" data-id="affiliates"><i class="fa-solid fa-network-wired"></i> <span>AffiliateLink</span></a>
                <a href="{{ route('admin.marketing.wishlists.index') }}" class="menu-link neon-trigger" data-id="wishlists"><i class="fa-solid fa-heart"></i> <span>SP Quan Tâm</span></a>
            </div>
        </div>

        {{-- NHÓM 10: NỘI DUNG --}}
        <div class="menu-group-box" data-group-id="content">
            <div class="group-title text-secondary">NỘI DUNG</div>
            <div class="menu-items-container" data-sort-group="content">
                <a href="{{ route('admin.content.posts.index') }}" class="menu-link neon-trigger" data-id="posts"><i class="fa-solid fa-newspaper"></i> <span>Tin Tức</span></a>
                <a href="{{ route('admin.content.banners.index') }}" class="menu-link neon-trigger" data-id="banners"><i class="fa-solid fa-image"></i> <span>Banner</span></a>
                <a href="{{ route('admin.content.menus.index') }}" class="menu-link neon-trigger" data-id="menus"><i class="fa-solid fa-bars"></i> <span>Menu Web</span></a>
                <a href="{{ route('admin.content.images.index') }}" class="menu-link neon-trigger" data-id="images"><i class="fa-solid fa-images"></i> <span>Thư Viện</span></a>
                <a href="{{ route('admin.content.game-subjects.index') }}" class="menu-link neon-trigger" data-id="games"><i class="fa-solid fa-gamepad"></i> <span>Game/Học</span></a>
            </div>
        </div>

        {{-- NHÓM 11: KHÁCH HÀNG (CRM) --}}
        <div class="menu-group-box" data-group-id="crm">
            <div class="group-title text-warning">KHÁCH HÀNG (CRM)</div>
            <div class="menu-items-container" data-sort-group="crm">
                <a href="{{ route('admin.crm.customers.index') }}" class="menu-link neon-trigger" data-id="customers"><i class="fa-solid fa-user-group"></i> <span>Khách Hàng</span></a>
                <a href="{{ route('admin.crm.chat-conversations.index') }}" class="menu-link neon-trigger" data-id="chats"><i class="fa-solid fa-comments"></i> <span>Hội Thoại</span></a>
                <a href="{{ route('admin.crm.requests.index') }}" class="menu-link neon-trigger" data-id="requests"><i class="fa-solid fa-envelope-open-text"></i> <span>Yêu Cầu</span></a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const menuWrapper = document.getElementById('admin-menu-container');
        const savedView = localStorage.getItem('admin_menu_view') || 'list';
        applyMenuView(savedView);

        function applyMenuView(mode) {
            if(mode === 'grid') { menuWrapper.classList.remove('view-mode-list'); menuWrapper.classList.add('view-mode-grid'); }
            else { menuWrapper.classList.remove('view-mode-grid'); menuWrapper.classList.add('view-mode-list'); }
        }

        // BỔ SUNG SỰ KIỆN NEON TRIGGER CHO MENU ITEMS
        const triggers = document.querySelectorAll('.neon-trigger');
        triggers.forEach(el => {
            el.addEventListener('mouseenter', () => {
                if(window.NeonManager) window.NeonManager.wakeUp();
            });
        });

        const groups = document.querySelectorAll('.menu-items-container');
        groups.forEach(group => {
            const groupId = group.getAttribute('data-sort-group');
            new Sortable(group, {
                group: { name: groupId, pull: false, put: false },
                animation: 150, ghostClass: 'sortable-ghost', dragClass: 'sortable-drag', delay: 100, delayOnTouchOnly: true,
                store: {
                    get: (sortable) => { const order = localStorage.getItem('admin_menu_order_' + groupId); return order ? order.split('|') : []; },
                    set: (sortable) => { localStorage.setItem('admin_menu_order_' + groupId, sortable.toArray().join('|')); }
                }
            });
        });

        window.renderMenuContent = function() {
            const menuInterface = document.getElementById('menu-interface');
            const chatInterface = document.getElementById('chat-interface');
            const settingsInterface = document.getElementById('settings-interface');
            if(menuInterface) menuInterface.classList.remove('d-none');
            if(chatInterface) chatInterface.classList.add('d-none');
            if(settingsInterface) settingsInterface.classList.add('d-none');
        }
    });
</script>
