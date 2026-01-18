{{-- 1. THƯ VIỆN SORTABLE (LOCAL) --}}
<script src="{{ asset('js/Sortable.min.js') }}"></script>

<div id="menu-interface" class="d-none">
    {{-- HEADER CỦA MENU --}}
    <div class="popup-header d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
        <div class="h5 mb-0 fw-bold d-flex align-items-center" style="color: var(--text-color);">
            <i class="fa-solid fa-compass me-2"></i>MENU
        </div>

        <div class="d-flex align-items-center gap-3">
            {{-- NÚT RESET VỊ TRÍ --}}
            <div class="view-switcher cursor-pointer" id="client-btn-reset-ask" title="Khôi phục vị trí mặc định">
                <i class="fa-solid fa-arrow-rotate-left"></i>
            </div>

            {{-- VIEW SWITCHER --}}
            <div class="view-switcher cursor-pointer" id="btn-switch-view" title="Đổi giao diện">
                <i class="fa-solid fa-list" id="icon-view-mode"></i>
            </div>

            {{-- THEME SWITCH --}}
            <div class="theme-switch-wrapper">
                <label for="theme" class="theme">
                    <span class="theme__toggle-wrap">
                        <input id="theme" class="theme__toggle" type="checkbox" role="switch" name="theme" value="dark">
                        <span class="theme__icon">
                            <span class="theme__icon-part"></span><span class="theme__icon-part"></span><span class="theme__icon-part"></span><span class="theme__icon-part"></span>
                            <span class="theme__icon-part"></span><span class="theme__icon-part"></span><span class="theme__icon-part"></span><span class="theme__icon-part"></span><span class="theme__icon-part"></span>
                        </span>
                    </span>
                </label>
            </div>
        </div>
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
                <a href="#" class="menu-link" data-id="account"><i class="fa-solid fa-user"></i> <span>Tài Khoản</span></a>
                <a href="#" class="menu-link" data-id="wishlist"><i class="fa-solid fa-heart"></i> <span>Yêu Thích</span></a>
            </div>
        </div>

        {{-- GROUP 3: MUA SẮM --}}
        <div class="menu-group-box">
            <div class="group-title text-warning">MUA SẮM</div>
            <div class="menu-items-container" data-group-id="shopping">
                <a href="#" class="menu-link" data-id="cart"><i class="fa-solid fa-cart-shopping"></i> <span>Giỏ Hàng</span> <span class="badge bg-danger ms-auto rounded-pill badge-num">3</span></a>
                <a href="#" class="menu-link" data-id="orders"><i class="fa-solid fa-box"></i> <span>Đơn Mua</span></a>
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

<style>
    /* 1. LAYOUT CHUNG */
    #menu-interface { width: 100%; overflow-y: auto; max-height: 80vh; scrollbar-width: thin; overscroll-behavior: contain; }
    #menu-interface::-webkit-scrollbar { width: 6px; } #menu-interface::-webkit-scrollbar-track { background: transparent; } #menu-interface::-webkit-scrollbar-thumb { background-color: var(--scrollbar-thumb); border-radius: 10px; }
    .popup-header { padding: 15px 25px 0 25px; border-bottom: 1px solid var(--popup-border); }

    /* 2. CẤU TRÚC CONTAINER CHÍNH */
    .menu-main-wrapper { padding: 25px; gap: 20px; }
    .menu-group-box { display: flex; flex-direction: column; margin-bottom: 5px; }

    /* Tiêu đề nhóm */
    .group-title {
        font-size: 0.75rem; font-weight: 800; text-transform: uppercase;
        color: var(--text-muted); margin-bottom: 8px; letter-spacing: 0.5px;
        padding-bottom: 4px; border-bottom: 2px solid rgba(0,0,0,0.03);
    }
    body.dark-mode .group-title { border-bottom-color: rgba(255,255,255,0.05); }

    /* 3. MENU ITEMS CONTAINER */
    .menu-items-container { min-height: 10px; }

    /* ====== MODE 1: LIST VIEW ====== */
    .view-mode-list { display: grid; grid-template-columns: repeat(2, 1fr); }
    .view-mode-list .menu-group-box { break-inside: avoid; margin-bottom: 0; }
    .view-mode-list .menu-items-container { display: flex; flex-direction: column; gap: 4px; }
    .view-mode-list .menu-link {
        display: flex; align-items: center; padding: 8px 12px;
        color: var(--text-color); text-decoration: none; border-radius: 8px;
        font-weight: 500; font-size: 0.95rem; transition: background 0.2s, transform 0.2s; white-space: nowrap; margin-bottom: 2px;
    }
    .view-mode-list .menu-link:hover { background-color: var(--link-hover-bg); color: var(--link-hover-text); transform: translateX(4px); }
    .view-mode-list .menu-link i { width: 24px; color: var(--text-muted); margin-right: 8px; text-align: center; transition: color 0.2s; }
    .view-mode-list .menu-link:hover i { color: var(--link-hover-text); }
    .view-mode-list .badge-num { margin-left: auto; }

    @media (max-width: 576px) { .view-mode-list { grid-template-columns: 1fr; } }

    /* ====== MODE 2: GRID VIEW ====== */
    .view-mode-grid { display: block; }
    .view-mode-grid .menu-group-box { margin-bottom: 25px; width: 100%; }
    .view-mode-grid .menu-items-container { display: flex; flex-wrap: wrap; gap: 15px; }

    .view-mode-grid .menu-link {
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        padding: 10px 5px; color: var(--text-color); text-decoration: none; border-radius: 12px;
        transition: all 0.2s; text-align: center; width: 90px; height: 90px;
        background: rgba(127, 127, 127, 0.05); border: 1px solid transparent; position: relative;
    }
    .view-mode-grid .menu-link:hover {
        background-color: var(--link-hover-bg); color: var(--link-hover-text);
        transform: translateY(-3px); box-shadow: 0 4px 10px rgba(0,0,0,0.05); border-color: var(--popup-border);
    }
    .view-mode-grid .menu-link i { font-size: 28px; margin-bottom: 8px; color: var(--primary); margin-right: 0; width: auto; }
    .view-mode-grid .menu-link span {
        font-size: 0.75rem; font-weight: 600; line-height: 1.1;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
        overflow: hidden; max-width: 100%; padding: 0 2px;
    }
    .view-mode-grid .badge-num { position: absolute; top: 6px; right: 6px; font-size: 10px; padding: 3px 6px; }

    /* DRAG & DROP EFFECTS */
    .sortable-ghost { opacity: 0.4; background: var(--link-hover-bg); border: 1px dashed var(--primary); }
    .sortable-drag { cursor: grabbing; opacity: 1; background: var(--popup-bg); box-shadow: 0 10px 20px rgba(0,0,0,0.2); transform: scale(1.05); }

    /* SWITCHERS */
    .view-switcher { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 50%; border: 1px solid var(--popup-border); background: var(--popup-bg); color: var(--text-muted); transition: 0.2s; }
    .view-switcher:hover { background: var(--primary); color: #fff; border-color: var(--primary); }

    /* THEME SWITCH STYLES */
    .theme { display: flex; align-items: center; font-size: 10px; } .theme__icon { transition: 0.3s; } .theme__icon, .theme__toggle { z-index: 1; } .theme__icon, .theme__icon-part { position: absolute; } .theme__icon { display: block; top: 0.5em; left: 0.5em; width: 1.5em; height: 1.5em; } .theme__icon-part { border-radius: 50%; box-shadow: 0.4em -0.4em 0 0.5em hsl(0,0%,100%) inset; top: calc(50% - 0.5em); left: calc(50% - 0.5em); width: 1em; height: 1em; transition: box-shadow var(--transDur) ease-in-out, opacity var(--transDur) ease-in-out, transform var(--transDur) ease-in-out; transform: scale(0.5); } .theme__icon-part ~ .theme__icon-part { background-color: hsl(0,0%,100%); border-radius: 0.05em; top: 50%; left: calc(50% - 0.05em); transform: rotate(0deg) translateY(0.5em); transform-origin: 50% 0; width: 0.1em; height: 0.2em; } .theme__icon-part:nth-child(3) { transform: rotate(45deg) translateY(0.45em); } .theme__icon-part:nth-child(4) { transform: rotate(90deg) translateY(0.45em); } .theme__icon-part:nth-child(5) { transform: rotate(135deg) translateY(0.45em); } .theme__icon-part:nth-child(6) { transform: rotate(180deg) translateY(0.45em); } .theme__icon-part:nth-child(7) { transform: rotate(225deg) translateY(0.45em); } .theme__icon-part:nth-child(8) { transform: rotate(270deg) translateY(0.5em); } .theme__icon-part:nth-child(9) { transform: rotate(315deg) translateY(0.5em); } .theme__label, .theme__toggle, .theme__toggle-wrap { position: relative; } .theme__toggle, .theme__toggle:before { display: block; } .theme__toggle { background-color: hsl(48,90%,85%); border-radius: 25% / 50%; box-shadow: 0 0 0 0.125em rgba(255,255,255,0.5); padding: 0.25em; width: 6em; height: 3em; -webkit-appearance: none; appearance: none; transition: background-color var(--transDur) ease-in-out, box-shadow 0.15s ease-in-out, transform var(--transDur) ease-in-out; cursor: pointer; } .theme__toggle:before { background-color: hsl(48,90%,55%); border-radius: 50%; content: ""; width: 2.5em; height: 2.5em; transition: 0.3s; } .theme__toggle:focus { box-shadow: 0 0 0 0.125em var(--primary); outline: transparent; } .theme__toggle:checked { background-color: hsl(198,90%,15%); } .theme__toggle:checked:before, .theme__toggle:checked ~ .theme__icon { transform: translateX(3em); } .theme__toggle:checked:before { background-color: hsl(198,90%,55%); } .theme__toggle:checked ~ .theme__icon .theme__icon-part:nth-child(1) { box-shadow: 0.2em -0.2em 0 0.2em hsl(0,0%,100%) inset; transform: scale(1); top: 0.2em; left: -0.2em; } .theme__toggle:checked ~ .theme__icon .theme__icon-part ~ .theme__icon-part { opacity: 0; } .theme__toggle:checked ~ .theme__icon .theme__icon-part:nth-child(2) { transform: rotate(45deg) translateY(0.8em); } .theme__toggle:checked ~ .theme__icon .theme__icon-part:nth-child(3) { transform: rotate(90deg) translateY(0.8em); } .theme__toggle:checked ~ .theme__icon .theme__icon-part:nth-child(4) { transform: rotate(135deg) translateY(0.8em); } .theme__toggle:checked ~ .theme__icon .theme__icon-part:nth-child(5) { transform: rotate(180deg) translateY(0.8em); } .theme__toggle:checked ~ .theme__icon .theme__icon-part:nth-child(6) { transform: rotate(225deg) translateY(0.8em); } .theme__toggle:checked ~ .theme__icon .theme__icon-part:nth-child(7) { transform: rotate(270deg) translateY(0.8em); } .theme__toggle:checked ~ .theme__icon .theme__icon-part:nth-child(8) { transform: rotate(315deg) translateY(0.8em); } .theme__toggle:checked ~ .theme__icon .theme__icon-part:nth-child(9) { transform: rotate(360deg) translateY(0.8em); } .theme__toggle-wrap { margin: 0 0.75em; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // --- 1. THEME LOGIC ---
        const themeToggle = document.querySelector('#theme');
        const body = document.body;
        if(localStorage.getItem('client_theme_preference') === 'dark') { body.classList.add('dark-mode'); if(themeToggle) themeToggle.checked = true; }
        if(themeToggle) themeToggle.addEventListener('change', (e) => { body.classList.toggle('dark-mode', e.target.checked); localStorage.setItem('client_theme_preference', e.target.checked ? 'dark' : 'light'); });

        // --- 2. SWITCH VIEW LOGIC ---
        const btnSwitch = document.getElementById('btn-switch-view');
        const iconSwitch = document.getElementById('icon-view-mode');
        const menuWrapper = document.getElementById('menu-container');

        const savedView = localStorage.getItem('client_menu_view') || 'list';
        setMenuView(savedView);

        if(btnSwitch) {
            btnSwitch.addEventListener('click', () => {
                const current = menuWrapper.classList.contains('view-mode-grid') ? 'grid' : 'list';
                const newState = current === 'grid' ? 'list' : 'grid';
                setMenuView(newState);
                setTimeout(() => { if(window.isSystemOpen) window.positionPopup('menu'); }, 50);
            });
        }

        function setMenuView(mode) {
            if(mode === 'grid') {
                menuWrapper.classList.remove('view-mode-list');
                menuWrapper.classList.add('view-mode-grid');
                iconSwitch.classList.replace('fa-table-cells', 'fa-list');
            } else {
                menuWrapper.classList.remove('view-mode-grid');
                menuWrapper.classList.add('view-mode-list');
                iconSwitch.classList.replace('fa-list', 'fa-table-cells');
            }
            localStorage.setItem('client_menu_view', mode);
        }

        // --- 3. GỌI MODAL RESET ĐỘNG ---
        const btnAsk = document.getElementById('client-btn-reset-ask');

        if(btnAsk) {
            btnAsk.addEventListener('click', () => {
                // Biến nội dung HTML
                const confirmTitle = 'Xác nhận đặt lại?';
                const confirmContent = `
                    <div style="text-align: center;">
                        <div style="margin-bottom: 10px; font-size: 40px; color: #f59e0b;">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                        <p>Vị trí các icon menu sẽ quay về mặc định.</p>
                        <p style="color: #ef4444; font-weight: 600; margin-top: 5px;">
                            Hành động này không thể hoàn tác!
                        </p>
                    </div>
                `;
                const btnCancelText = 'Huỷ bỏ';
                const btnConfirmText = 'Đặt lại ngay';

                // Gọi hàm Global
                window.showConfirm(
                    confirmTitle,
                    confirmContent,
                    btnCancelText,
                    btnConfirmText,
                    function() {
                        Object.keys(localStorage).forEach(key => {
                            if (key.startsWith('client_menu_order_')) {
                                localStorage.removeItem(key);
                            }
                        });
                        location.reload();
                    }
                );
            });
        }

        // --- 4. SORTABLE JS LOGIC ---
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

        // --- 5. EXPORT RENDER FUNCTION ---
        window.renderMenuContent = function() {
            const menuInterface = document.getElementById('menu-interface');
            const chatInterface = document.getElementById('chat-interface');
            menuInterface.classList.remove('d-none');
            chatInterface.classList.add('d-none');
        }
    });
</script>
