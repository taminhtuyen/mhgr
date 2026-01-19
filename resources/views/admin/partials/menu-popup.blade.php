{{-- 1. THƯ VIỆN SORTABLE (LOCAL) --}}
<script src="{{ asset('js/Sortable.min.js') }}"></script>

<div id="menu-interface" class="d-none">
    <style>
        /* --- 1. CSS VARIABLES CHO BORDER NỔI BẬT --- */
        :root {
            --popup-border-highlight: rgba(0, 0, 0, 0.15); /* Chế độ sáng: Viền tối */
        }
        body.dark-mode {
            --popup-border-highlight: rgba(255, 255, 255, 0.2); /* Chế độ tối: Viền sáng */
        }

        /* 3. LAYOUT CHUNG & SCROLL */
        #menu-interface { width: 100%; overflow-y: auto; max-height: 80vh; scrollbar-width: thin; overscroll-behavior: contain; }
        #menu-interface::-webkit-scrollbar { width: 6px; } #menu-interface::-webkit-scrollbar-track { background: transparent; } #menu-interface::-webkit-scrollbar-thumb { background-color: var(--scrollbar-thumb); border-radius: 10px; }
        .popup-header { padding: 18px 25px 0 25px; border-bottom: 1px solid var(--popup-border); }
        .menu-main-wrapper { padding: 25px; gap: 20px; }
        .menu-group-box { display: flex; flex-direction: column; margin-bottom: 5px; }

        .group-title {
            font-size: 0.72rem; font-weight: 800; text-transform: uppercase;
            color: var(--text-muted); margin-bottom: 10px; letter-spacing: 0.8px;
            padding-bottom: 5px; border-bottom: 2px solid rgba(0,0,0,0.03);
        }
        body.dark-mode .group-title { border-bottom-color: rgba(255,255,255,0.05); }

        /* 4. MENU LINKS & MODES */
        .menu-link { display: flex; align-items: center; color: var(--text-color); text-decoration: none; border-radius: 10px; font-weight: 500; font-size: 0.92rem; transition: all 0.2s; white-space: nowrap; }

        .view-mode-list { display: grid; grid-template-columns: repeat(4, 1fr); }
        .view-mode-list .menu-group-box { break-inside: avoid; }
        .view-mode-list .menu-items-container { display: flex; flex-direction: column; gap: 5px; }
        .view-mode-list .menu-link { padding: 9px 14px; margin-bottom: 2px; }
        .view-mode-list .menu-link:hover { background-color: var(--link-hover-bg); color: var(--link-hover-text); transform: translateX(5px); }
        .view-mode-list .menu-link i { width: 24px; color: var(--text-muted); margin-right: 10px; text-align: center; font-size: 1rem; }

        @media (max-width: 998px) { .view-mode-list { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 576px) { .view-mode-list { grid-template-columns: 1fr; } }

        .view-mode-grid { display: block; }
        .view-mode-grid .menu-group-box { margin-bottom: 25px; width: 100%; }
        .view-mode-grid .menu-items-container { display: flex; flex-wrap: wrap; gap: 15px; }
        .view-mode-grid .menu-link { flex-direction: column; align-items: center; justify-content: center; padding: 12px 5px; width: 92px; height: 92px; background: rgba(127, 127, 127, 0.05); border: 1px solid transparent; position: relative; }
        .view-mode-grid .menu-link:hover { background-color: var(--link-hover-bg); color: var(--link-hover-text); transform: translateY(-4px); box-shadow: 0 6px 15px rgba(0,0,0,0.08); border-color: var(--popup-border); }
        .view-mode-grid .menu-link i { font-size: 28px; margin-bottom: 10px; color: var(--primary); }
        .view-mode-grid .menu-link span { font-size: 0.75rem; font-weight: 600; line-height: 1.2; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; text-align: center; }

        .view-switcher { width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; border-radius: 50%; border: 1px solid var(--popup-border); background: var(--popup-bg); color: var(--text-muted); transition: all 0.2s; }
        .view-switcher:hover { background: var(--primary); color: #fff; border-color: var(--primary); transform: scale(1.05); }

        /* Dropdown Item Style */
        .dropdown-item { color: var(--text-color) !important; transition: all 0.2s; font-weight: 500; }
        .dropdown-item:hover { background-color: var(--link-hover-bg) !important; color: var(--link-hover-text) !important; }
        .dropdown-item i { width: 20px; text-align: center; color: var(--text-muted); }
        .dropdown-item:hover i { color: var(--link-hover-text); }
        .glass-effect.dropdown-menu { border: 1.5px solid var(--popup-border-highlight) !important; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2) !important; }
    </style>

    {{-- HEADER CỦA MENU --}}
    <div class="popup-header d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
        <div class="h5 mb-0 fw-bold d-flex align-items-center" style="color: var(--text-color);">
            <i class="fa-solid fa-bars-staggered me-2 text-primary"></i>MENU
        </div>
    </div>

    {{-- CONTAINER CHÍNH --}}
    <div class="menu-main-wrapper view-mode-list" id="admin-menu-container">
        {{-- === NHÓM 1: TỔNG QUAN === --}}
        <div class="menu-group-box">
            <div class="group-title text-primary">TỔNG QUAN</div>
            <div class="menu-items-container" data-group-id="overview">
                <a href="{{ route('admin.dashboard') }}" class="menu-link" data-id="dashboard"><i class="fa-solid fa-gauge"></i> <span>Tổng Quan</span></a>
            </div>
        </div>
        {{-- === NHÓM 2: BÁN HÀNG === --}}
        <div class="menu-group-box">
            <div class="group-title text-success">BÁN HÀNG</div>
            <div class="menu-items-container" data-group-id="sales">
                <a href="{{ route('admin.sales.orders.index') }}" class="menu-link" data-id="orders"><i class="fa-solid fa-cart-shopping"></i> <span>Đơn Hàng</span></a>
                <a href="{{ route('admin.sales.shipping-shipments.index') }}" class="menu-link" data-id="deliveries"><i class="fa-solid fa-truck"></i> <span>Vận Chuyển</span></a>
                <a href="{{ route('admin.sales.returns.index') }}" class="menu-link" data-id="returns"><i class="fa-solid fa-rotate-left"></i> <span>Trả Hàng</span></a>
                <a href="{{ route('admin.sales.tax-invoices.index') }}" class="menu-link" data-id="invoices"><i class="fa-solid fa-file-invoice"></i> <span>Hóa Đơn</span></a>
                <a href="{{ route('admin.sales.carts.index') }}" class="menu-link" data-id="carts"><i class="fa-solid fa-cart-arrow-down"></i> <span>Giỏ Treo</span></a>
            </div>
        </div>
        {{-- === NHÓM 3: HỆ THỐNG === --}}
        <div class="menu-group-box">
            <div class="group-title text-dark">HỆ THỐNG</div>
            <div class="menu-items-container" data-group-id="system">
                <a href="{{ route('admin.system.settings.index') }}" class="menu-link" data-id="settings"><i class="fa-solid fa-gear"></i> <span>Cài Đặt</span></a>
                <a href="{{ route('admin.system.users.index') }}" class="menu-link" data-id="users"><i class="fa-solid fa-user-shield"></i> <span>Quản Trị</span></a>
                <a href="{{ route('admin.system.roles.index') }}" class="menu-link" data-id="roles"><i class="fa-solid fa-user-lock"></i> <span>Phân Quyền</span></a>
                <a href="{{ route('admin.system.locations.index') }}" class="menu-link" data-id="locations"><i class="fa-solid fa-map-location-dot"></i> <span>Vị Trí</span></a>
                <a href="{{ route('admin.system.logs.index') }}" class="menu-link" data-id="logs"><i class="fa-solid fa-terminal"></i> <span>Logs</span></a>
            </div>
        </div>
        {{-- === NHÓM 4: SẢN PHẨM === --}}
        <div class="menu-group-box">
            <div class="group-title text-warning">SẢN PHẨM</div>
            <div class="menu-items-container" data-group-id="products">
                <a href="{{ route('admin.catalog.products.index') }}" class="menu-link" data-id="products_list"><i class="fa-solid fa-box-open"></i> <span>Sản Phẩm</span></a>
                <a href="{{ route('admin.catalog.categories.index') }}" class="menu-link" data-id="categories"><i class="fa-solid fa-layer-group"></i> <span>Danh Mục</span></a>
                <a href="{{ route('admin.catalog.attributes.index') }}" class="menu-link" data-id="attributes"><i class="fa-solid fa-tags"></i> <span>Thuộc Tính</span></a>
                <a href="{{ route('admin.catalog.suppliers.index') }}" class="menu-link" data-id="suppliers"><i class="fa-solid fa-handshake"></i> <span>Nhà Cung Cấp</span></a>
                <a href="{{ route('admin.catalog.product-reviews.index') }}" class="menu-link" data-id="reviews"><i class="fa-solid fa-star"></i> <span>Đánh Giá</span></a>
            </div>
        </div>
        {{-- === NHÓM 5: KHO HÀNG === --}}
        <div class="menu-group-box">
            <div class="group-title text-danger">KHO HÀNG</div>
            <div class="menu-items-container" data-group-id="inventory">
                <a href="{{ route('admin.inventory.stocks.index') }}" class="menu-link" data-id="stocks"><i class="fa-solid fa-cubes"></i> <span>Tồn Kho</span></a>
                <a href="{{ route('admin.inventory.warehouses.index') }}" class="menu-link" data-id="warehouses"><i class="fa-solid fa-warehouse"></i> <span>Danh Sách Kho</span></a>
                <a href="{{ route('admin.inventory.import-orders.index') }}" class="menu-link" data-id="po"><i class="fa-solid fa-file-import"></i> <span>Nhập (PO)</span></a>
                <a href="{{ route('admin.inventory.transactions.index') }}" class="menu-link" data-id="transactions"><i class="fa-solid fa-clock-rotate-left"></i> <span>Lịch Sử Kho</span></a>
            </div>
        </div>
        {{-- === NHÓM 6: TÀI CHÍNH === --}}
        <div class="menu-group-box">
            <div class="group-title text-primary">TÀI CHÍNH</div>
            <div class="menu-items-container" data-group-id="finance">
                {{-- [ĐÃ SỬA] Route profits -> profit-distribution-groups --}}
                <a href="{{ route('admin.finance.profit-distribution-groups.index') }}" class="menu-link" data-id="profits"><i class="fa-solid fa-percent"></i> <span>Lợi Nhuận</span></a>
                <a href="{{ route('admin.finance.reward-wallets.index') }}" class="menu-link" data-id="wallets"><i class="fa-solid fa-wallet"></i> <span>Ví Tiền</span></a>
                <a href="{{ route('admin.finance.commissions.index') }}" class="menu-link" data-id="commissions"><i class="fa-solid fa-money-bill-transfer"></i> <span>Hoa Hồng</span></a>
            </div>
        </div>
        {{-- === NHÓM 7: KÝ GỬI === --}}
        <div class="menu-group-box">
            <div class="group-title text-secondary">KÝ GỬI</div>
            <div class="menu-items-container" data-group-id="consignment">
                {{-- [ĐÃ SỬA] Route orders -> consignments --}}
                <a href="{{ route('admin.consignment.consignments.index') }}" class="menu-link" data-id="consignment_orders"><i class="fa-solid fa-clipboard-list"></i> <span>Đơn Ký Gửi</span></a>
                <a href="{{ route('admin.consignment.customers.index') }}" class="menu-link" data-id="consignment_customers"><i class="fa-solid fa-users-rectangle"></i> <span>Khách Ký Gửi</span></a>
            </div>
        </div>
        {{-- === NHÓM 8: MARKETING === --}}
        <div class="menu-group-box">
            <div class="group-title text-info">MARKETING</div>
            <div class="menu-items-container" data-group-id="marketing">
                <a href="{{ route('admin.marketing.promotions.index') }}" class="menu-link" data-id="promotions"><i class="fa-solid fa-bullhorn"></i> <span>Chiến Dịch</span></a>
                <a href="{{ route('admin.marketing.promotion-coupons.index') }}" class="menu-link" data-id="coupons"><i class="fa-solid fa-ticket"></i> <span>Voucher</span></a>
                <a href="{{ route('admin.marketing.flash-sales.index') }}" class="menu-link" data-id="flash"><i class="fa-solid fa-bolt"></i> <span>Flash Sale</span></a>
                <a href="{{ route('admin.marketing.affiliate-links.index') }}" class="menu-link" data-id="affiliates"><i class="fa-solid fa-network-wired"></i> <span>AffiliateLink</span></a>
            </div>
        </div>
        {{-- === NHÓM 9: NỘI DUNG === --}}
        <div class="menu-group-box">
            <div class="group-title text-secondary">NỘI DUNG</div>
            <div class="menu-items-container" data-group-id="content">
                <a href="{{ route('admin.content.posts.index') }}" class="menu-link" data-id="posts"><i class="fa-solid fa-newspaper"></i> <span>Tin Tức</span></a>
                <a href="{{ route('admin.content.banners.index') }}" class="menu-link" data-id="banners"><i class="fa-solid fa-image"></i> <span>Banner</span></a>
                <a href="{{ route('admin.content.menus.index') }}" class="menu-link" data-id="menus"><i class="fa-solid fa-bars"></i> <span>Menu Web</span></a>
                {{-- [ĐÃ XÓA] Route pages (đã bị xóa khỏi hệ thống) --}}
                <a href="{{ route('admin.content.images.index') }}" class="menu-link" data-id="images"><i class="fa-solid fa-images"></i> <span>Thư Viện</span></a>
                <a href="{{ route('admin.content.game-subjects.index') }}" class="menu-link" data-id="games"><i class="fa-solid fa-gamepad"></i> <span>Game/Học</span></a>
            </div>
        </div>
        {{-- === NHÓM 10: KHÁCH HÀNG (CRM) === --}}
        <div class="menu-group-box">
            <div class="group-title text-warning">KHÁCH HÀNG (CRM)</div>
            <div class="menu-items-container" data-group-id="crm">
                <a href="{{ route('admin.crm.customers.index') }}" class="menu-link" data-id="customers"><i class="fa-solid fa-user-group"></i> <span>Khách Hàng</span></a>
                <a href="{{ route('admin.crm.chat-conversations.index') }}" class="menu-link" data-id="chats"><i class="fa-solid fa-comments"></i> <span>Hội Thoại</span></a>
                <a href="{{ route('admin.crm.requests.index') }}" class="menu-link" data-id="requests"><i class="fa-solid fa-envelope-open-text"></i> <span>Yêu Cầu</span></a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // --- 1. VIEW MODE DROPDOWN LOGIC (ADMIN) ---
        const menuWrapper = document.getElementById('admin-menu-container');

        // Logic check trạng thái đã lưu
        const savedView = localStorage.getItem('admin_menu_view') || 'list';
        applyMenuView(savedView);

        function applyMenuView(mode) {
            if(mode === 'grid') {
                menuWrapper.classList.remove('view-mode-list');
                menuWrapper.classList.add('view-mode-grid');
            } else {
                menuWrapper.classList.remove('view-mode-grid');
                menuWrapper.classList.add('view-mode-list');
            }
        }

        // --- 2. SORTABLE JS LOGIC ---
        const groups = document.querySelectorAll('.menu-items-container');
        groups.forEach(group => {
            const groupId = group.getAttribute('data-group-id');
            new Sortable(group, {
                group: { name: groupId, pull: false, put: false },
                animation: 150,
                ghostClass: 'sortable-ghost',
                dragClass: 'sortable-drag',
                delay: 100, delayOnTouchOnly: true,
                store: {
                    get: function (sortable) {
                        const order = localStorage.getItem('admin_menu_order_' + groupId);
                        return order ? order.split('|') : [];
                    },
                    set: function (sortable) {
                        const order = sortable.toArray();
                        localStorage.setItem('admin_menu_order_' + groupId, order.join('|'));
                    }
                }
            });
        });

        // --- 3. EXPORT RENDER FUNCTION ---
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
