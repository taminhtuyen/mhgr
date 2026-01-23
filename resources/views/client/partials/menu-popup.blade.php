{{-- 1. THƯ VIỆN SORTABLE (LOCAL) --}}
<script src="{{ asset('js/Sortable.min.js') }}"></script>

<div id="menu-interface" class="d-none">
    <style>
        /* --- 1. CSS VARIABLES CHO BORDER NỔI BẬT --- */
        :root {
            --popup-border-highlight: rgba(0, 0, 0, 0.15);
        }
        body.dark-mode {
            --popup-border-highlight: rgba(255, 255, 255, 0.2);
        }

        .glass-effect.dropdown-menu {
            border: 1.5px solid var(--popup-border-highlight) !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2) !important;
        }

        .dropdown-item { color: var(--text-color) !important; transition: all 0.2s; font-weight: 500; }
        .dropdown-item:hover { background-color: var(--link-hover-bg) !important; color: var(--link-hover-text) !important; }
        .dropdown-item i { width: 20px; text-align: center; color: var(--text-muted); }
        .dropdown-item:hover i { color: var(--link-hover-text); }

        /* 3. LAYOUT CHUNG & SCROLL */
        #menu-interface { width: 100%; overflow-y: auto; max-height: 80vh; scrollbar-width: thin; overscroll-behavior: contain; }
        #menu-interface::-webkit-scrollbar { width: 6px; }
        #menu-interface::-webkit-scrollbar-track { background: transparent; }
        #menu-interface::-webkit-scrollbar-thumb { background-color: var(--scrollbar-thumb); border-radius: 10px; }

        /* [CẬP NHẬT] STICKY HEADER CHO MENU CLIENT - ĐÃ GIẢM OPACITY */
        .popup-header {
            padding: 18px 25px 15px 25px;
            border-bottom: 1px solid var(--popup-border);

            /* Sticky Logic */
            position: sticky;
            top: 0;
            z-index: 50;

            /* [QUAN TRỌNG] Chỉnh màu nền trong suốt hơn (0.8) để thấy nội dung mờ bên dưới */
            background-color: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px); /* Tăng độ blur lên một chút */
            -webkit-backdrop-filter: blur(12px);

            margin-top: -1px;
        }

        /* Màu nền header riêng cho Dark Mode */
        body.dark-mode .popup-header {
            background-color: rgba(15, 23, 42, 0.8); /* Màu tối nhưng trong suốt 80% */
        }

        .menu-main-wrapper { padding: 25px; gap: 20px; }
        .menu-group-box { display: flex; flex-direction: column; margin-bottom: 5px; }

        .group-title {
            font-size: 0.72rem; font-weight: 800; text-transform: uppercase;
            color: var(--text-muted); margin-bottom: 10px; letter-spacing: 0.8px;
            padding-bottom: 5px; border-bottom: 2px solid rgba(0,0,0,0.03);
        }
        body.dark-mode .group-title { border-bottom-color: rgba(255,255,255,0.05); }

        /* 4. CHIA CỘT THÔNG MINH */
        .menu-link {
            display: flex; align-items: center; color: var(--text-color); text-decoration: none;
            border-radius: 10px; font-weight: 500; font-size: 0.92rem; transition: all 0.2s;
            white-space: nowrap; overflow: hidden;
        }
        .menu-link span { text-overflow: ellipsis; overflow: hidden; }

        /* Chế độ Danh sách */
        .view-mode-list { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; }
        .view-mode-list .menu-group-box { break-inside: avoid; }
        .view-mode-list .menu-items-container { display: flex; flex-direction: column; gap: 5px; }
        .view-mode-list .menu-link { padding: 9px 14px; }
        .view-mode-list .menu-link:hover { background-color: var(--link-hover-bg); color: var(--link-hover-text); transform: translateX(5px); }
        .view-mode-list .menu-link i { width: 24px; color: var(--text-muted); margin-right: 10px; text-align: center; font-size: 1rem; }

        @media (max-width: 998px) { .view-mode-list { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 767.98px) { .view-mode-list { grid-template-columns: 1fr; } }

        /* Chế độ Lưới (Grid) */
        .view-mode-grid { display: block; }
        .view-mode-grid .menu-group-box { margin-bottom: 25px; width: 100%; }
        .view-mode-grid .menu-items-container { display: flex; flex-wrap: wrap; gap: 15px; }
        .view-mode-grid .menu-link { flex-direction: column; align-items: center; justify-content: center; padding: 12px 5px; width: 92px; height: 92px; background: rgba(127, 127, 127, 0.05); border: 1px solid transparent; position: relative; }
        .view-mode-grid .menu-link:hover { background-color: var(--link-hover-bg); color: var(--link-hover-text); transform: translateY(-4px); box-shadow: 0 6px 15px rgba(0,0,0,0.08); border-color: var(--popup-border); }
        .view-mode-grid .menu-link i { font-size: 28px; margin-bottom: 10px; color: var(--primary); }
        .view-mode-grid .menu-link span { font-size: 0.75rem; font-weight: 600; line-height: 1.2; text-align: center; }

        .view-switcher { width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; border-radius: 50%; border: 1px solid var(--popup-border); background: var(--popup-bg); color: var(--text-muted); transition: all 0.2s; }
        .view-switcher:hover { background: var(--primary); color: #fff; border-color: var(--primary); transform: scale(1.05); }

        /* Style nút đóng */
        .btn-close-popup {
            width: 32px; height: 32px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 50%;
            transition: all 0.2s;
            color: var(--text-muted);
            border: 1px solid transparent;
        }
        .btn-close-popup:hover {
            background-color: rgba(127,127,127,0.1);
            color: var(--text-color);
        }
    </style>

    {{-- HEADER CỦA MENU (STICKY) --}}
    <div class="popup-header d-flex justify-content-between align-items-center">
        <div class="h5 mb-0 fw-bold d-flex align-items-center" style="color: var(--text-color);">
            <i class="fa-solid fa-bars-staggered me-2 text-primary"></i>MENU
        </div>
        {{-- Nút đóng popup --}}
        <button class="btn btn-sm btn-icon text-muted btn-close-popup bg-transparent border-0" onclick="closeAll()" title="Đóng">
            <i class="fa-solid fa-xmark" style="font-size: 1.2rem;"></i>
        </button>
    </div>

    {{-- CONTENT CỦA MENU --}}
    <div class="menu-main-wrapper view-mode-list" id="menu-container">
        {{-- GROUP 1: KHÁM PHÁ --}}
        <div class="menu-group-box">
            <div class="group-title text-primary">KHÁM PHÁ</div>
            <div class="menu-items-container" data-group-id="explore">
                <a href="/" class="menu-link" data-id="home"><i class="fa-solid fa-house"></i> <span>Trang Chủ</span></a>
                <a href="#" class="menu-link" data-id="store"><i class="fa-solid fa-store"></i> <span>Cửa Hàng</span></a>
                <a href="#" class="menu-link" data-id="hot"><i class="fa-solid fa-fire"></i> <span>Khuyến Mãi Hot</span></a>
                <a href="#" class="menu-link" data-id="news"><i class="fa-solid fa-newspaper"></i> <span>Tin Tức</span></a>
            </div>
        </div>

        {{-- GROUP 2: CÁ NHÂN --}}
        <div class="menu-group-box">
            <div class="group-title text-success">CÁ NHÂN</div>
            <div class="menu-items-container" data-group-id="personal">
                <a href="#" class="menu-link" data-id="account"><i class="fa-solid fa-user-gear"></i> <span>Tài Khoản</span></a>
                <a href="#" class="menu-link" data-id="wishlist"><i class="fa-solid fa-heart"></i> <span>Yêu Thích</span></a>
            </div>
        </div>

        {{-- GROUP 3: MUA SẮM --}}
        <div class="menu-group-box">
            <div class="group-title text-warning">MUA SẮM</div>
            <div class="menu-items-container" data-group-id="shopping">
                <a href="#" class="menu-link" data-id="cart"><i class="fa-solid fa-cart-shopping"></i> <span>Giỏ Hàng</span> <span class="badge bg-danger ms-auto rounded-pill badge-num">3</span></a>
                <a href="#" class="menu-link" data-id="orders"><i class="fa-solid fa-truck-fast"></i> <span>Đơn Mua</span></a>
                <a href="#" class="menu-link" data-id="history"><i class="fa-solid fa-clock-rotate-left"></i> <span>Lịch Sử</span></a>
            </div>
        </div>

        {{-- GROUP 4: HỖ TRỢ --}}
        <div class="menu-group-box">
            <div class="group-title text-info">HỖ TRỢ</div>
            <div class="menu-items-container" data-group-id="support">
                <a href="#" class="menu-link" data-id="help"><i class="fa-solid fa-circle-question"></i> <span>Trợ Giúp</span></a>
                <a href="#" class="menu-link" data-id="security"><i class="fa-solid fa-shield-halved"></i> <span>Bảo Mật</span></a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // --- 1. VIEW MODE LOGIC (CLIENT) ---
        const menuWrapper = document.getElementById('menu-container');
        const savedView = localStorage.getItem('client_menu_view') || 'list';
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
                        const order = localStorage.getItem('client_menu_order_' + groupId);
                        return order ? order.split('|') : [];
                    },
                    set: function (sortable) {
                        const order = sortable.toArray();
                        localStorage.setItem('client_menu_order_' + groupId, order.join('|'));
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
