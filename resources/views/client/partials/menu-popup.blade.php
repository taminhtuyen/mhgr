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

        /* 2. CSS CHO THANH TRƯỢT FONT SIZE (ĐỒNG BỘ ADMIN) --- */
        #fontsize-range { cursor: pointer; height: 6px; }
        #fontsize-range::-webkit-slider-runnable-track {
            background: var(--input-darker);
            height: 6px;
            border-radius: 10px;
            border: 1px solid var(--popup-border);
        }
        #fontsize-range::-webkit-slider-thumb {
            margin-top: -6px;
            background: var(--primary);
            box-shadow: 0 0 10px rgba(var(--primary), 0.4);
            border: 2px solid #fff;
            height: 18px;
            width: 18px;
            transition: transform 0.1s ease;
        }
        #fontsize-range:active::-webkit-slider-thumb { transform: scale(1.2); }

        .dropdown-item { color: var(--text-color) !important; transition: all 0.2s; font-weight: 500; }
        .dropdown-item:hover { background-color: var(--link-hover-bg) !important; color: var(--link-hover-text) !important; }
        .dropdown-item i { width: 20px; text-align: center; color: var(--text-muted); }
        .dropdown-item:hover i { color: var(--link-hover-text); }

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

        /* 4. CHIA CỘT THÔNG MINH (HỌC TỪ ADMIN) */
        .menu-link {
            display: flex; align-items: center; color: var(--text-color); text-decoration: none;
            border-radius: 10px; font-weight: 500; font-size: 0.92rem; transition: all 0.2s;
            white-space: nowrap; overflow: hidden;
        }
        .menu-link span { text-overflow: ellipsis; overflow: hidden; } /* Cắt chữ nếu quá dài */

        /* Chế độ Danh sách */
        .view-mode-list { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; }
        .view-mode-list .menu-group-box { break-inside: avoid; }
        .view-mode-list .menu-items-container { display: flex; flex-direction: column; gap: 5px; }
        .view-mode-list .menu-link { padding: 9px 14px; }
        .view-mode-list .menu-link:hover { background-color: var(--link-hover-bg); color: var(--link-hover-text); transform: translateX(5px); }
        .view-mode-list .menu-link i { width: 24px; color: var(--text-muted); margin-right: 10px; text-align: center; font-size: 1rem; }

        /* Breakpoints Chia Cột */
        @media (max-width: 998px) { .view-mode-list { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 767.98px) { .view-mode-list { grid-template-columns: 1fr; } } /* Mobile về 1 cột */

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

        /* 5. THEME SWITCH ANIMATION (FIXED) */
        .theme { display: flex; align-items: center; font-size: 10px; line-height: 1; }
        .theme__toggle-wrap { position: relative; width: 6em; height: 3em; }
        .theme__icon { transition: 0.3s; z-index: 1; position: absolute; display: block; top: 0.75em; left: 0.75em; width: 1.5em; height: 1.5em; pointer-events: none; }
        .theme__icon-part { border-radius: 50%; box-shadow: 0.4em -0.4em 0 0.5em hsl(0,0%,100%) inset; top: calc(50% - 0.5em); left: calc(50% - 0.5em); width: 1em; height: 1em; position: absolute; transition: box-shadow 0.3s ease-in-out, opacity 0.3s ease-in-out, transform 0.3s ease-in-out; transform: scale(0.5); }
        .theme__icon-part ~ .theme__icon-part { background-color: hsl(0,0%,100%); border-radius: 0.05em; top: 50%; left: calc(50% - 0.05em); transform: rotate(0deg) translateY(0.5em); transform-origin: 50% 0; width: 0.1em; height: 0.2em; }
        .theme__icon-part:nth-child(3) { transform: rotate(45deg) translateY(0.45em); }
        .theme__icon-part:nth-child(4) { transform: rotate(90deg) translateY(0.45em); }
        .theme__icon-part:nth-child(5) { transform: rotate(135deg) translateY(0.45em); }
        .theme__icon-part:nth-child(6) { transform: rotate(180deg) translateY(0.45em); }
        .theme__icon-part:nth-child(7) { transform: rotate(225deg) translateY(0.45em); }
        .theme__icon-part:nth-child(8) { transform: rotate(270deg) translateY(0.5em); }
        .theme__icon-part:nth-child(9) { transform: rotate(315deg) translateY(0.5em); }
        .theme__toggle { background-color: hsl(48,90%,85%); border-radius: 1.5em; box-shadow: 0 0 0 0.125em rgba(255,255,255,0.5); padding: 0.25em; width: 100%; height: 100%; -webkit-appearance: none; appearance: none; transition: background-color 0.3s ease-in-out; cursor: pointer; position: relative; display: block; margin: 0; }
        .theme__toggle:before { background-color: hsl(48,90%,55%); border-radius: 50%; content: ""; width: 2.5em; height: 2.5em; transition: 0.3s; display: block; }
        .theme__toggle:focus { box-shadow: 0 0 0 0.125em var(--primary); outline: transparent; }
        .theme__toggle:checked { background-color: hsl(198,90%,15%); }
        .theme__toggle:checked:before { transform: translateX(3em); background-color: hsl(198,90%,55%); }
        .theme__toggle:checked ~ .theme__icon { transform: translateX(3em); }
        .theme__toggle:checked ~ .theme__icon .theme__icon-part:nth-child(1) { box-shadow: 0.2em -0.2em 0 0.2em hsl(0,0%,100%) inset; transform: scale(1); top: 0.2em; left: -0.2em; }
        .theme__toggle:checked ~ .theme__icon .theme__icon-part ~ .theme__icon-part { opacity: 0; }
    </style>

    {{-- HEADER CỦA MENU --}}
    <div class="popup-header d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
        <div class="h5 mb-0 fw-bold d-flex align-items-center" style="color: var(--text-color);">
            <i class="fa-solid fa-bars-staggered me-2 text-primary"></i>MENU
        </div>

        <div class="d-flex align-items-center gap-3">
            {{-- 1. ĐIỀU CHỈNH KÍCH CỠ CHỮ --}}
            <div class="dropdown">
                <div class="view-switcher cursor-pointer" id="btn-fontsize-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" title="Kích thước chữ">
                    <i class="fa-solid fa-font"></i>
                </div>
                <div class="dropdown-menu dropdown-menu-end p-3 shadow-lg border-0 glass-effect" style="min-width: 280px; background-color: var(--popup-bg); margin-top: 12px;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <label class="form-label small fw-bold mb-0" style="color: var(--text-color);">Cỡ chữ hệ thống</label>
                        <span id="fontsize-ratio-display" class="badge rounded-pill bg-primary px-2" style="font-size: 0.75rem; font-weight: 600;">1.0x</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <i class="fa-solid fa-font small text-muted"></i>
                        <input type="range" class="form-range flex-grow-1" id="fontsize-range" min="12" max="22" step="1" value="16">
                        <i class="fa-solid fa-font fs-5 text-primary"></i>
                    </div>
                </div>
            </div>

            {{-- 2. ĐIỀU KHIỂN HIỂN THỊ & SẮP XẾP --}}
            <div class="dropdown">
                <div class="view-switcher cursor-pointer" id="btn-view-options" data-bs-toggle="dropdown" title="Tuỳ chọn hiển thị">
                    <i class="fa-solid fa-table-cells" id="icon-view-mode"></i>
                </div>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 glass-effect" style="background-color: var(--popup-bg); margin-top: 12px; min-width: 230px;">
                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="#" id="action-switch-view">
                            <i class="fa-solid fa-list-ul" id="icon-action-view"></i>
                            <span id="text-action-view">Hiển thị kiểu danh sách</span>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider" style="border-color: var(--popup-border);"></li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2 py-2 text-danger" href="#" id="action-reset-menu">
                            <i class="fa-solid fa-arrow-rotate-left"></i>
                            <span>Sắp xếp menu mặc định</span>
                        </a>
                    </li>
                </ul>
            </div>

            {{-- 3. NÚT CHUYỂN ĐỔI CHẾ ĐỘ NGÀY ĐÊM --}}
            <div class="theme-switch-wrapper">
                <label for="theme-toggle-input" class="theme">
                    <span class="theme__toggle-wrap">
                        <input id="theme-toggle-input" class="theme__toggle" type="checkbox" role="switch" name="theme" value="dark">
                        <span class="theme__icon">
                            <span class="theme__icon-part"></span><span class="theme__icon-part"></span><span class="theme__icon-part"></span><span class="theme__icon-part"></span>
                            <span class="theme__icon-part"></span><span class="theme__icon-part"></span><span class="theme__icon-part"></span><span class="theme__icon-part"></span><span class="theme__icon-part"></span>
                        </span>
                    </span>
                </label>
            </div>
        </div>
    </div>

    {{-- CONTENT CỦA MENU (CHIA CỘT THÔNG MINH) --}}
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
        // --- 1. THEME LOGIC ---
        const themeToggle = document.querySelector('#theme-toggle-input');
        const body = document.body;

        if(localStorage.getItem('client_theme_preference') === 'dark') {
            body.classList.add('dark-mode');
            if(themeToggle) themeToggle.checked = true;
        }

        if(themeToggle) {
            themeToggle.addEventListener('change', (e) => {
                body.classList.toggle('dark-mode', e.target.checked);
                localStorage.setItem('client_theme_preference', e.target.checked ? 'dark' : 'light');
            });
        }

        // --- 2. GLOBAL FONT SIZE LOGIC ---
        const fsRange = document.getElementById('fontsize-range');
        const fsDisplay = document.getElementById('fontsize-ratio-display');
        const htmlEl = document.documentElement;

        function updateFontSize(val) {
            htmlEl.style.fontSize = val + 'px';
            const ratio = (val / 16).toFixed(1);
            if(fsDisplay) fsDisplay.innerText = ratio + 'x';
            localStorage.setItem('client_global_fontsize', val);
        }

        const savedFs = localStorage.getItem('client_global_fontsize') || '16';
        if(fsRange) {
            fsRange.value = savedFs;
            updateFontSize(savedFs);
            fsRange.addEventListener('input', (e) => updateFontSize(e.target.value));
        }

        // --- 3. VIEW MODE & DROPDOWN LOGIC ---
        const btnActionSwitch = document.getElementById('action-switch-view');
        const iconMode = document.getElementById('icon-view-mode');
        const iconAction = document.getElementById('icon-action-view');
        const textAction = document.getElementById('text-action-view');
        const menuWrapper = document.getElementById('menu-container');

        const savedView = localStorage.getItem('client_menu_view') || 'list';
        applyMenuView(savedView);

        if(btnActionSwitch) {
            btnActionSwitch.addEventListener('click', (e) => {
                e.preventDefault();
                const current = menuWrapper.classList.contains('view-mode-grid') ? 'grid' : 'list';
                const newState = current === 'grid' ? 'list' : 'grid';
                applyMenuView(newState);
                setTimeout(() => { if(window.isSystemOpen) window.positionPopup('menu'); }, 50);
            });
        }

        function applyMenuView(mode) {
            if(mode === 'grid') {
                menuWrapper.classList.remove('view-mode-list');
                menuWrapper.classList.add('view-mode-grid');
                iconMode.className = 'fa-solid fa-table-cells';
                iconAction.className = 'fa-solid fa-list-ul';
                textAction.innerText = 'Hiển thị kiểu danh sách';
            } else {
                menuWrapper.classList.remove('view-mode-grid');
                menuWrapper.classList.add('view-mode-list');
                iconMode.className = 'fa-solid fa-list-ul';
                iconAction.className = 'fa-solid fa-table-cells';
                textAction.innerText = 'Hiển thị kiểu lưới';
            }
            localStorage.setItem('client_menu_view', mode);
        }

        // --- 4. RESET ORDER LOGIC ---
        const btnReset = document.getElementById('action-reset-menu');
        if(btnReset) {
            btnReset.addEventListener('click', (e) => {
                e.preventDefault();
                window.showConfirm(
                    'Xác nhận đặt lại?',
                    'Vị trí sắp xếp các icon sẽ quay về mặc định ban đầu.',
                    function() {
                        Object.keys(localStorage).forEach(key => {
                            if (key.startsWith('client_menu_order_')) localStorage.removeItem(key);
                        });
                        location.reload();
                    },
                    { confirmText: 'Đặt lại ngay', confirmColor: 'danger' }
                );
            });
        }

        // --- 5. SORTABLE JS LOGIC ---
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

        // --- 6. EXPORT RENDER FUNCTION ---
        window.renderMenuContent = function() {
            const menuInterface = document.getElementById('menu-interface');
            const chatInterface = document.getElementById('chat-interface');
            if(menuInterface) menuInterface.classList.remove('d-none');
            if(chatInterface) chatInterface.classList.add('d-none');
        }
    });
</script>
