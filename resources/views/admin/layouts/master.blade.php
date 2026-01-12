<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* --- 1. VÙNG CONTENT CHÍNH --- */
        #main-wrapper {
            width: 100%;
            min-height: 100vh;
            padding: 20px;
            transition: all 0.3s ease;
        }

        /* --- 2. BACKDROP (Lớp phủ tối màn hình) --- */
        #nav-backdrop {
            position: fixed;
            top: 0; left: 0;
            width: 100vw; height: 100vh;
            background-color: rgba(0, 0, 0, 0.4); /* Màu tối mờ */
            z-index: 9998; /* Dưới bong bóng và popup */
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease;
            backdrop-filter: blur(2px);
        }
        #nav-backdrop.active {
            opacity: 1;
            visibility: visible;
        }

        /* --- 3. BONG BÓNG MENU --- */
        #nav-bubble {
            position: fixed;
            bottom: 40px;
            right: 40px;
            width: 60px; height: 60px;
            background: linear-gradient(135deg, #2563eb, #1e40af);
            color: #fff;
            border-radius: 50%;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.4);
            display: flex;
            align-items: center; justify-content: center;
            font-size: 24px;
            cursor: pointer;
            z-index: 10000;
            user-select: none;
            transition: transform 0.2s;
        }
        #nav-bubble:hover { transform: scale(1.1); }
        #nav-bubble:active { transform: scale(0.9); }

        /* --- 4. MENU POPUP (Smart Layout) --- */
        #nav-popup {
            position: fixed;
            z-index: 9999;

            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            border: 1px solid rgba(0,0,0,0.05);

            /* Ẩn mặc định */
            opacity: 0;
            visibility: hidden;
            transform: scale(0.95);
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);

            /* Kích thước & Scroll */
            max-width: 95vw;
            width: max-content;
            overflow-y: auto;
            scrollbar-width: thin;
        }

        #nav-popup.active {
            opacity: 1;
            visibility: visible;
            transform: scale(1);
        }

        /* Grid Layout cho Menu */
        .popup-grid {
            display: flex;
            flex-direction: row;
            padding: 25px;
            gap: 40px; /* Khoảng cách rộng hơn giữa các cột */
        }

        .menu-column {
            min-width: 170px;
            display: flex;
            flex-direction: column;
        }

        .group-title {
            font-size: 0.8rem;
            font-weight: 800;
            text-transform: uppercase;
            color: #94a3b8;
            margin-bottom: 12px;
            padding-bottom: 5px;
            border-bottom: 2px solid #f1f5f9;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        /* Spacer cho các nhóm trong cùng 1 cột */
        .group-spacer { margin-top: 25px; }

        .menu-link {
            display: flex; align-items: center;
            padding: 8px 10px;
            color: #334155;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            border-radius: 8px;
            transition: 0.2s;
            white-space: nowrap;
            margin-bottom: 2px;
        }
        .menu-link:hover {
            background-color: #eff6ff;
            color: #2563eb;
            transform: translateX(3px);
        }
        .menu-link i {
            width: 24px;
            color: #94a3b8;
            margin-right: 5px;
            font-size: 0.9em;
            text-align: center;
        }
        .menu-link:hover i { color: #2563eb; }

        @media (max-width: 992px) {
            .popup-grid { flex-wrap: wrap; }
        }
        @media (max-width: 576px) {
            .popup-grid { flex-direction: column; gap: 20px; }
            .menu-column { min-width: 100%; }
        }
    </style>
</head>
<body>

<div id="nav-backdrop"></div>

<div id="main-wrapper">
    @yield('content')
</div>

<div id="nav-bubble" title="Menu">
    <i class="fa-solid fa-bars" id="bubble-icon"></i>
</div>

<div id="nav-popup">
    <div class="popup-grid">

        <div class="menu-column">
            <div class="group-title text-primary">TỔNG QUAN</div>
            <a href="{{ route('admin.dashboard') }}" class="menu-link"><i class="fa-solid fa-gauge"></i> Tổng Quan</a>

            <div class="group-title text-success group-spacer">BÁN HÀNG</div>
            <a href="{{ route('admin.sales.orders.index') }}" class="menu-link"><i class="fa-solid fa-cart-shopping"></i> Đơn Hàng</a>
            <a href="{{ route('admin.sales.deliveries.index') }}" class="menu-link"><i class="fa-solid fa-truck"></i> Vận Chuyển</a>
            <a href="{{ route('admin.sales.returns.index') }}" class="menu-link"><i class="fa-solid fa-rotate-left"></i> Trả Hàng</a>
            <a href="{{ route('admin.sales.invoices.index') }}" class="menu-link"><i class="fa-solid fa-file-invoice"></i> Hóa Đơn</a>
            <a href="{{ route('admin.sales.carts.index') }}" class="menu-link"><i class="fa-solid fa-cart-arrow-down"></i> Giỏ Hàng Treo</a>
        </div>

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

    <script>
        // Đây là mẹo nhỏ để di chuyển nhóm HỆ THỐNG vào Cột 1 nếu muốn bằng JS,
        // nhưng tôi sẽ viết thẳng vào HTML cho bạn dễ copy.
        // Xem lại phần HTML bên dưới để thấy nhóm HỆ THỐNG.
    </script>
</div>

<div id="nav-popup-content-fixed" style="display:none;">
    <div class="popup-grid">

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
</div>

<script>
    // Tôi chèn nội dung menu vào đúng div #nav-popup
    document.getElementById('nav-popup').innerHTML = document.getElementById('nav-popup-content-fixed').innerHTML;

    document.addEventListener('DOMContentLoaded', () => {
        const bubble = document.getElementById('nav-bubble');
        const popup = document.getElementById('nav-popup');
        const backdrop = document.getElementById('nav-backdrop');
        const icon = document.getElementById('bubble-icon');

        let isDragging = false;
        let startX, startY, initialLeft, initialTop;

        // 1. Load vị trí cũ
        const savedPos = localStorage.getItem('bubblePos');
        if (savedPos) {
            const pos = JSON.parse(savedPos);
            bubble.style.left = pos.left;
            bubble.style.top = pos.top;
            bubble.style.right = 'auto'; bubble.style.bottom = 'auto';
        }

        // 2. Kéo thả (Drag)
        bubble.addEventListener('mousedown', (e) => {
            isDragging = false;
            startX = e.clientX; startY = e.clientY;
            const rect = bubble.getBoundingClientRect();
            initialLeft = rect.left; initialTop = rect.top;
            document.addEventListener('mousemove', onMouseMove);
            document.addEventListener('mouseup', onMouseUp);
        });

        function onMouseMove(e) {
            const dx = e.clientX - startX;
            const dy = e.clientY - startY;
            if (Math.abs(dx) > 5 || Math.abs(dy) > 5) {
                isDragging = true;
                closeMenu();
                bubble.style.left = `${initialLeft + dx}px`;
                bubble.style.top = `${initialTop + dy}px`;
                bubble.style.right = 'auto'; bubble.style.bottom = 'auto';
            }
        }

        function onMouseUp() {
            document.removeEventListener('mousemove', onMouseMove);
            document.removeEventListener('mouseup', onMouseUp);
            if (isDragging) {
                localStorage.setItem('bubblePos', JSON.stringify({
                    left: bubble.style.left, top: bubble.style.top
                }));
            }
        }

        // 3. Xử lý Mở Menu Thông Minh
        bubble.addEventListener('click', () => {
            if (isDragging) return;

            if (popup.classList.contains('active')) {
                closeMenu();
            } else {
                openMenu();
            }
        });

        function openMenu() {
            const bubbleRect = bubble.getBoundingClientRect();
            const screenW = window.innerWidth;
            const screenH = window.innerHeight;
            const gap = 15;

            // Reset style
            popup.style.top = 'auto'; popup.style.bottom = 'auto';
            popup.style.left = 'auto'; popup.style.right = 'auto';
            popup.style.maxHeight = 'none';

            // --- TÍNH TOÁN NGANG ---
            if (bubbleRect.left > screenW / 2) {
                // Bong bóng bên phải -> Menu hiện bên trái bong bóng
                popup.style.right = (screenW - bubbleRect.left + gap) + 'px';
                popup.style.left = 'auto';
                popup.style.transformOrigin = 'bottom right';
            } else {
                // Bong bóng bên trái -> Menu hiện bên phải bong bóng
                popup.style.left = (bubbleRect.right + gap) + 'px';
                popup.style.right = 'auto';
                popup.style.transformOrigin = 'bottom left';
            }

            // --- TÍNH TOÁN DỌC ---
            if (bubbleRect.top > screenH / 2) {
                // Bong bóng ở dưới -> Menu mọc lên
                popup.style.bottom = (screenH - bubbleRect.bottom) + 'px';
                popup.style.top = 'auto';
                popup.style.maxHeight = (bubbleRect.bottom - 20) + 'px';
                popup.style.transformOrigin = popup.style.transformOrigin.replace('top', 'bottom');
            } else {
                // Bong bóng ở trên -> Menu đổ xuống
                popup.style.top = bubbleRect.top + 'px';
                popup.style.bottom = 'auto';
                popup.style.maxHeight = (screenH - bubbleRect.top - 20) + 'px';
                popup.style.transformOrigin = popup.style.transformOrigin.replace('bottom', 'top');
            }

            popup.classList.add('active');
            backdrop.classList.add('active');
            icon.classList.replace('fa-bars', 'fa-xmark');
        }

        function closeMenu() {
            popup.classList.remove('active');
            backdrop.classList.remove('active');
            icon.classList.replace('fa-xmark', 'fa-bars');
        }

        backdrop.addEventListener('click', closeMenu);
    });
</script>
</body>
</html>
