{{-- resources/views/client/partials/menu-popup.blade.php --}}
{{-- 1. THƯ VIỆN SORTABLE (LOCAL) --}}
<script src="{{ asset('js/Sortable.min.js') }}"></script>

<div id="menu-interface" class="d-none">
    <style>
        /* --- 1. BIẾN MÀU SẮC NEON (SHARP STYLE) --- */
        :root {
            --popup-border-highlight: rgba(0, 0, 0, 0.1);
            --neon-glow: var(--primary);
            --link-hover-bg: rgba(0, 0, 0, 0.03);
        }

        body.dark-mode {
            --popup-border-highlight: rgba(255, 255, 255, 0.1);
            --link-hover-bg: rgba(255, 255, 255, 0.05);
        }

        /* Định nghĩa màu Neon riêng cho từng nhóm */
        .menu-group-box[data-group="explore"] { --neon-glow: #007bff; }
        .menu-group-box[data-group="personal"] { --neon-glow: #28a745; }
        .menu-group-box[data-group="shopping"] { --neon-glow: #ffc107; }
        .menu-group-box[data-group="support"]  { --neon-glow: #17a2b8; }

        /* --- 2. ĐỊNH DẠNG CHUNG (CLEAN TEXT) --- */
        .menu-link {
            display: flex;
            align-items: center;
            text-decoration: none !important;
            color: var(--text-color);
            transition: all 0.25s ease;
            border-radius: 0.5rem;
            font-weight: 500;
            position: relative; /* QUAN TRỌNG: Làm mốc cho nhãn badge absolute */
        }

        .menu-link span, .menu-link i {
            transition: all 0.2s ease;
        }

        /* Định dạng riêng cho Nhãn số lượng (Badge) */
        .cart-badge {
            position: absolute;
            top: 0.375rem;
            right: 0.375rem;
            font-size: 0.625rem;
            padding: 0.25rem 0.4rem;
            min-width: 1.125rem;
            z-index: 5;
            line-height: 1;
            box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.2);
        }

        /* --- 3. XỬ LÝ HOVER THEO CHẾ ĐỘ --- */

        /* Mặc định cho Dark Mode List */
        .menu-link:hover span,
        .menu-link:hover i {
            color: #ffffff !important;
            text-shadow:
                0 0 0.125rem #ffffff,
                0 0 0.3125rem var(--neon-glow),
                0 0 0.625rem var(--neon-glow);
        }

        /* [LIGHT MODE] - CHẾ ĐỘ DANH SÁCH */
        body:not(.dark-mode) .view-mode-list .menu-link:hover span,
        body:not(.dark-mode) .view-mode-list .menu-link:hover i {
            color: var(--text-color) !important;
            text-shadow: 0 0 0.5rem var(--neon-glow);
        }

        /* [LIGHT MODE] - CHẾ ĐỘ LƯỚI: Đổi màu chữ theo nhóm, không đổ bóng */
        body:not(.dark-mode) .view-mode-grid .menu-link:hover span,
        body:not(.dark-mode) .view-mode-grid .menu-link:hover i {
            color: var(--neon-glow) !important;
            text-shadow: none !important;
        }

        /* [DARK MODE] - CHẾ ĐỘ LƯỚI: Giảm chói */
        body.dark-mode .view-mode-grid .menu-link:hover span,
        body.dark-mode .view-mode-grid .menu-link:hover i {
            text-shadow: 0 0 0.3125rem var(--neon-glow) !important;
        }

        /* --- 4. CHẾ ĐỘ DANH SÁCH (LIST VIEW) --- */
        .view-mode-list {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.25rem;
        }

        .view-mode-list .menu-items-container {
            display: flex;
            flex-direction: column;
            gap: 0.3125rem;
        }

        .view-mode-list .menu-link { padding: 0.625rem 0.875rem; }
        .view-mode-list .menu-link:hover { background-color: var(--link-hover-bg); }

        .view-mode-list .menu-link i {
            width: 1.5rem;
            margin-right: 0.75rem;
            text-align: center;
            color: var(--text-muted);
        }

        /* --- 5. CHẾ ĐỘ LƯỚI (GRID VIEW) --- */
        .view-mode-grid .menu-items-container {
            display: flex;
            flex-wrap: wrap;
            gap: 0.9375rem;
        }

        .view-mode-grid .menu-link {
            flex-direction: column;
            justify-content: center;
            width: 5.75rem;
            height: 5.75rem;
            background: transparent;
            border: 0.0625rem solid var(--popup-border-highlight);
            border-radius: 0.75rem;
        }

        .view-mode-grid .menu-link:hover {
            background-color: transparent !important;
            border-color: #ffffff !important;
            box-shadow:
                inset 0 0 0.3125rem var(--neon-glow),
                0 0 0.3125rem var(--neon-glow),
                0 0 0.9375rem var(--neon-glow);
            transform: none !important;
        }

        .view-mode-grid .menu-link i {
            font-size: 1.75rem;
            margin-bottom: 0.5rem;
            color: var(--neon-glow);
        }

        .view-mode-grid .menu-link span {
            font-size: 0.75rem;
            font-weight: 700;
            text-align: center;
        }

        /* --- 6. GIAO DIỆN HEADER & SCROLL --- */
        #menu-interface {
            width: 100%;
            overflow-y: auto;
            max-height: 80vh;
            scrollbar-width: thin;
            overscroll-behavior: contain;
        }

        #menu-interface::-webkit-scrollbar { width: 0.375rem; }
        #menu-interface::-webkit-scrollbar-thumb { background-color: var(--scrollbar-thumb); border-radius: 0.625rem; }

        .popup-header {
            padding: 1.125rem 1.5625rem;
            border-bottom: 0.0625rem solid var(--popup-border);
            position: sticky;
            top: 0;
            z-index: 50;
            background-color: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(0.75rem);
            -webkit-backdrop-filter: blur(0.75rem);
        }

        body.dark-mode .popup-header { background-color: rgba(15, 23, 42, 0.8); }

        .menu-main-wrapper { padding: 1.5625rem; }

        .group-title {
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 0.75rem;
            letter-spacing: 0.0625rem;
            padding-bottom: 0.25rem;
            border-bottom: 0.125rem solid rgba(0,0,0,0.03);
        }
        body.dark-mode .group-title { border-bottom-color: rgba(255,255,255,0.05); }

        @media (max-width: 998px) { .view-mode-list { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 576px) { .view-mode-list { grid-template-columns: 1fr; } }
    </style>

    {{-- HEADER --}}
    <div class="popup-header d-flex justify-content-between align-items-center">
        <div class="h5 mb-0 fw-bold d-flex align-items-center" style="color: var(--text-color);">
            <i class="fa-solid fa-bars-staggered me-2 text-primary"></i>MENU
        </div>
        <button class="btn btn-icon text-muted border-0 bg-transparent" onclick="closeAll()" style="width: 2.5rem; height: 2.5rem; border-radius: 50%;">
            <i class="fa-solid fa-xmark" style="font-size: 1.25rem;"></i>
        </button>
    </div>

    {{-- CONTENT --}}
    <div class="menu-main-wrapper view-mode-list" id="menu-container">
        {{-- GROUP 1: KHÁM PHÁ --}}
        <div class="menu-group-box" data-group="explore">
            <div class="group-title text-primary">KHÁM PHÁ</div>
            <div class="menu-items-container" data-group-id="explore">
                <a href="/" class="menu-link" data-id="home"><i class="fa-solid fa-house"></i> <span>Trang Chủ</span></a>
                <a href="#" class="menu-link" data-id="store"><i class="fa-solid fa-store"></i> <span>Cửa Hàng</span></a>
                <a href="#" class="menu-link" data-id="hot"><i class="fa-solid fa-fire"></i> <span>Khuyến Mãi Hot</span></a>
                <a href="#" class="menu-link" data-id="news"><i class="fa-solid fa-newspaper"></i> <span>Tin Tức</span></a>
            </div>
        </div>

        {{-- GROUP 2: CÁ NHÂN --}}
        <div class="menu-group-box" data-group="personal">
            <div class="group-title text-success">CÁ NHÂN</div>
            <div class="menu-items-container" data-group-id="personal">
                <a href="#" class="menu-link" data-id="account"><i class="fa-solid fa-user-gear"></i> <span>Tài Khoản</span></a>
                <a href="#" class="menu-link" data-id="wishlist"><i class="fa-solid fa-heart"></i> <span>Yêu Thích</span></a>
            </div>
        </div>

        {{-- GROUP 3: MUA SẮM --}}
        <div class="menu-group-box" data-group="shopping">
            <div class="group-title text-warning">MUA SẮM</div>
            <div class="menu-items-container" data-group-id="shopping">
                <a href="#" class="menu-link" data-id="cart">
                    <i class="fa-solid fa-cart-shopping"></i> <span>Giỏ Hàng</span>
                    {{-- NHÃN SỐ LƯỢNG ĐÃ ĐƯỢC ĐƯA LÊN GÓC CAO BÊN PHẢI --}}
                    <span class="badge bg-danger rounded-pill cart-badge">3</span>
                </a>
                <a href="#" class="menu-link" data-id="orders"><i class="fa-solid fa-truck-fast"></i> <span>Đơn Mua</span></a>
                <a href="#" class="menu-link" data-id="history"><i class="fa-solid fa-clock-rotate-left"></i> <span>Lịch Sử</span></a>
            </div>
        </div>

        {{-- GROUP 4: HỖ TRỢ --}}
        <div class="menu-group-box" data-group="support">
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
                    get: (sortable) => {
                        const order = localStorage.getItem('client_menu_order_' + groupId);
                        return order ? order.split('|') : [];
                    },
                    set: (sortable) => {
                        const order = sortable.toArray();
                        localStorage.setItem('client_menu_order_' + groupId, order.join('|'));
                    }
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
