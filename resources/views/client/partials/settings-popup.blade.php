<div id="settings-interface" class="d-none">
    <style>
        /* =========================================
           CORE LAYOUT & SCROLLBAR
           ========================================= */
        #settings-interface {
            width: 420px;
            max-width: 100%;
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 20px;
            max-height: 80vh;
            overflow-y: auto;
            overscroll-behavior: contain;
            scrollbar-width: thin;
        }

        #settings-interface::-webkit-scrollbar { width: 6px; }
        #settings-interface::-webkit-scrollbar-track { background: transparent; }
        #settings-interface::-webkit-scrollbar-thumb { background-color: var(--scrollbar-thumb); border-radius: 10px; }

        @media (max-width: 998px) {
            #settings-interface {
                width: 92vw;
                padding: 0;
                max-height: 75vh;
            }
        }

        /* =========================================
           STICKY HEADER
           ========================================= */
        .settings-header {
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--text-color);
            border-bottom: 2px solid var(--popup-border);
            position: sticky;
            top: 0;
            z-index: 50;
            /* Nền trong suốt mờ (Glassmorphism) */
            background-color: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            padding: 20px 25px 15px 25px;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        /* Header Dark Mode */
        body.dark-mode .settings-header {
            background-color: rgba(15, 23, 42, 0.85);
        }

        /* =========================================
           GROUP & ITEM STYLING
           ========================================= */
        .settings-group {
            background: rgba(127, 127, 127, 0.05);
            border-radius: 16px;
            padding: 18px;
            border: 1px solid var(--popup-border);
            margin: 0 25px;
        }
        .settings-group:last-child {
            margin-bottom: 25px;
        }

        .settings-group-title {
            font-size: 0.75rem;
            text-transform: uppercase;
            color: var(--text-muted);
            font-weight: 800;
            margin-bottom: 15px;
            letter-spacing: 0.5px;
            opacity: 0.8;
        }

        .setting-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }
        .setting-item:last-child { margin-bottom: 0; }

        .setting-info { display: flex; flex-direction: column; }

        .setting-label {
            font-size: 0.95rem; font-weight: 600; color: var(--text-color);
            display: flex; align-items: center; gap: 8px; line-height: 1.4;
        }

        .setting-subtext {
            font-size: 0.75rem; color: var(--text-muted);
            margin-top: 2px; margin-left: 24px; font-weight: 400;
        }

        /* =========================================
           BUTTON 1: THEME SWITCH (SUN/MOON)
           Style: Theme 14
           ========================================= */
        .switch-theme {
            /* 17px ~ 1.0625rem */
            font-size: 1.0625rem;
            position: relative;
            display: inline-block;
            width: 3.5em;
            height: 2em;
        }
        .switch-theme input {
            opacity: 0; width: 0; height: 0;
        }
        .slider-theme {
            background-color: #2185d6;
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            cursor: pointer;
            border-radius: 30px;
            box-shadow: 0 0 0 rgba(33, 133, 214, 0);
            transition: all 0.4s ease;
        }
        .slider-theme:hover {
            box-shadow: 0 0 15px rgba(33, 133, 214, 0.5);
        }
        .slider-theme::before {
            position: absolute;
            content: "";
            height: 1.4em;
            width: 1.4em;
            border-radius: 50%;
            left: 10%;
            bottom: 15%;
            box-shadow: inset 15px -4px 0px 15px #fdf906;
            background-color: #28096b;
            transition: all 0.4s ease;
            transform-origin: center;
        }
        .slider-theme:hover::before {
            transform: rotate(45deg);
        }
        .clouds_stars {
            position: absolute;
            content: "";
            border-radius: 50%;
            height: 10px;
            width: 10px;
            left: 70%;
            bottom: 50%;
            background-color: #fff;
            transition: all 0.3s;
            box-shadow: -12px 0 0 0 white, -6px 0 0 1.6px white, 0.3px 16px 0 white, -6.5px 16px 0 white;
            filter: blur(0.55px);
        }
        /* Checked State */
        .switch-theme input:checked ~ .clouds_stars {
            transform: translateX(-20px);
            height: 2px;
            width: 2px;
            border-radius: 50%;
            left: 80%;
            top: 15%;
            background-color: #fff;
            backdrop-filter: blur(10px);
            transition: all 0.3s;
            box-shadow: -7px 10px 0 #fff, 8px 15px 0 #fff, -17px 1px 0 #fff, -20px 10px 0 #fff, -7px 23px 0 #fff, -15px 25px 0 #fff;
            filter: none;
            animation: twinkle 2s infinite;
        }
        .switch-theme input:checked + .slider-theme {
            background-color: #28096b !important;
        }
        .switch-theme input:checked + .slider-theme::before {
            transform: translateX(100%);
            box-shadow: inset 8px -4px 0 0 #fff;
        }
        .switch-theme input:checked + .slider-theme:hover::before {
            transform: translateX(100%) rotate(-45deg);
        }
        @keyframes twinkle { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }

        /* =========================================
           BUTTON 2: STANDARD TOGGLE (LITE)
           Style: iOS Style (Switch 31)
           ========================================= */
        .toggle-switch-lite {
            display: inline-block; position: relative; width: 50px; height: 30px;
        }
        .toggle-input-lite { display: none; }
        .toggle-label-lite {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background-color: #e9e9eb; border-radius: 34px; cursor: pointer;
            transition: background-color 0.3s;
        }
        .toggle-label-lite:before {
            content: ""; position: absolute; top: 2px; left: 2px; width: 26px; height: 26px;
            background-color: #fff; border-radius: 50%;
            transition: transform 0.3s cubic-bezier(0.4, 0.0, 0.2, 1);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .toggle-input-lite:checked + .toggle-label-lite { background-color: #34C759; }
        .toggle-input-lite:checked + .toggle-label-lite:before { transform: translateX(20px); }

        /* Auto Dark Mode Style cho Button Lite */
        body.dark-mode .toggle-label-lite {
            background-color: rgba(255, 255, 255, 0.15); border: 1px solid rgba(255, 255, 255, 0.05);
        }
        body.dark-mode .toggle-input-lite:checked + .toggle-label-lite {
            background-color: #30D158; border-color: transparent;
        }

        /* =========================================
           OTHER CONTROLS
           ========================================= */
        .btn-view-toggle {
            width: 42px; height: 42px; border-radius: 12px; border: 1px solid var(--popup-border);
            background: var(--bg-body); color: var(--text-muted); display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem; transition: all 0.2s; cursor: pointer;
        }
        .btn-view-toggle:hover { background: var(--primary); color: #fff; border-color: var(--primary); transform: scale(1.05); }

        .btn-reset-menu {
            border: 1px solid rgba(239, 68, 68, 0.3); background: rgba(239, 68, 68, 0.05); color: #ef4444;
            padding: 8px 12px; border-radius: 8px; font-size: 0.85rem; font-weight: 600;
            cursor: pointer; transition: 0.2s; display: flex; align-items: center; gap: 6px;
        }
        .btn-reset-menu:hover { background: #ef4444; color: #fff; }

        /* Slider Font Size */
        #settings-fontsize-range { cursor: pointer; height: 6px; width: 120px; }
        #settings-fontsize-range::-webkit-slider-runnable-track {
            background: var(--input-darker); height: 6px; border-radius: 10px; border: 1px solid var(--popup-border);
        }
        #settings-fontsize-range::-webkit-slider-thumb {
            margin-top: -6px; background: var(--primary); box-shadow: 0 0 10px rgba(var(--primary), 0.4);
            border: 2px solid #fff; height: 18px; width: 18px; transition: transform 0.1s ease;
            -webkit-appearance: none; border-radius: 50%;
        }

        .cursor-pointer { cursor: pointer; }
        .user-select-none { -webkit-user-select: none; user-select: none; }
    </style>

    {{-- HEADER (STICKY) --}}
    <div class="settings-header">
        <div class="d-flex align-items-center gap-2">
            <i class="fa-solid fa-gears text-primary"></i> CÀI ĐẶT
        </div>
        {{-- Nút đóng --}}
        <button class="btn btn-sm btn-icon text-muted ms-auto bg-transparent border-0" onclick="closeAll()" title="Đóng">
            <i class="fa-solid fa-xmark" style="font-size: 1.2rem;"></i>
        </button>
    </div>

    {{-- NHÓM 1: GIAO DIỆN --}}
    <div class="settings-group">
        <div class="settings-group-title">Giao diện & Hiển thị</div>

        {{-- 1.1 Chế độ tối (NEW UI) --}}
        <div class="setting-item">
            <div class="setting-info">
                <div class="setting-label"><i class="fa-solid fa-circle-half-stroke text-muted"></i> Chế độ tối</div>
                <div class="setting-subtext" id="desc-theme">Đang sử dụng chế độ sáng</div>
            </div>

            <label class="switch-theme">
                <input type="checkbox" id="settings-theme-toggle">
                <span class="slider-theme"></span>
                <span class="clouds_stars"></span>
            </label>
        </div>

        {{-- 1.2 Cỡ chữ (NEW CLICKABLE 'A') --}}
        <div class="setting-item">
            <div class="setting-info">
                <div class="setting-label"><i class="fa-solid fa-text-height text-muted"></i> Cỡ chữ</div>
                <div class="setting-subtext" id="desc-font">Kích thước hiện tại: 16px</div>
            </div>
            <div class="d-flex align-items-center gap-2">
                {{-- Button giảm --}}
                <small class="text-muted cursor-pointer user-select-none" id="btn-decrease-font" style="font-size: 0.7rem;" title="Giảm cỡ chữ">A</small>

                <input type="range" class="form-range" id="settings-fontsize-range" min="12" max="22" step="1" value="16">

                {{-- Button tăng --}}
                <span class="text-primary fw-bold cursor-pointer user-select-none" id="btn-increase-font" style="font-size: 1rem;" title="Tăng cỡ chữ">A</span>
            </div>
        </div>

        {{-- 1.3 Kiểu menu --}}
        <div class="setting-item">
            <div class="setting-info">
                <div class="setting-label"><i class="fa-solid fa-table-layout text-muted"></i> Kiểu Menu</div>
                <div class="setting-subtext" id="desc-view">Đang hiển thị dạng danh sách</div>
            </div>
            <button class="btn-view-toggle" id="settings-view-toggle" title="Chuyển đổi kiểu hiển thị">
                <i class="fa-solid fa-list-ul"></i>
            </button>
        </div>

        {{-- 1.4 Sắp xếp menu --}}
        <div class="setting-item">
            <div class="setting-info">
                <div class="setting-label"><i class="fa-solid fa-arrow-rotate-left text-muted"></i> Sắp xếp menu</div>
                <div class="setting-subtext">Khôi phục vị trí mặc định</div>
            </div>
            <button class="btn-reset-menu" id="settings-reset-menu">
                <i class="fa-solid fa-rotate"></i> Đặt lại
            </button>
        </div>
    </div>

    {{-- NHÓM 2: NHẮN TIN --}}
    <div class="settings-group">
        <div class="settings-group-title">Trò chuyện & Tin nhắn</div>

        {{-- 2.1 Phím Enter để gửi (NEW UI) --}}
        <div class="setting-item">
            <div class="setting-info">
                <div class="setting-label"><i class="fa-solid fa-keyboard text-muted"></i> Enter để gửi</div>
                <div class="setting-subtext" id="desc-enter">Gửi tin nhắn bằng phím Enter</div>
            </div>

            <div class="toggle-switch-lite">
                <input class="toggle-input-lite" id="settings-enter-send" type="checkbox" />
                <label class="toggle-label-lite" for="settings-enter-send"></label>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // --- 1. RENDER FUNCTION (CLIENT) ---
        window.renderSettingsContent = function() {
            const menu = document.getElementById('menu-interface');
            const chat = document.getElementById('chat-interface');
            const settings = document.getElementById('settings-interface');

            if (menu) menu.classList.add('d-none');
            if (chat) chat.classList.add('d-none');
            if (settings) settings.classList.remove('d-none');
        }

        // --- 2. DARK MODE LOGIC (CLIENT) ---
        const themeToggle = document.getElementById('settings-theme-toggle');
        const descTheme = document.getElementById('desc-theme');
        const body = document.body;

        const updateThemeText = (isDark) => {
            if(descTheme) descTheme.innerText = isDark ? 'Đang bật chế độ tối (Dark Mode)' : 'Đang sử dụng chế độ sáng (Light Mode)';
        };

        // Init Check
        if(localStorage.getItem('client_theme_preference') === 'dark') {
            if(themeToggle) themeToggle.checked = true;
            updateThemeText(true);
        } else {
            updateThemeText(false);
        }

        if(themeToggle) {
            themeToggle.addEventListener('change', (e) => {
                const isDark = e.target.checked;
                body.classList.toggle('dark-mode', isDark);
                localStorage.setItem('client_theme_preference', isDark ? 'dark' : 'light');
                updateThemeText(isDark);
            });
        }

        // --- 3. FONT SIZE LOGIC (CLIENT) ---
        const fsRange = document.getElementById('settings-fontsize-range');
        const descFont = document.getElementById('desc-font');
        const btnDecrease = document.getElementById('btn-decrease-font');
        const btnIncrease = document.getElementById('btn-increase-font');
        const htmlEl = document.documentElement;

        // Function chung để áp dụng font size
        const applyFontSize = (val) => {
            // Giới hạn
            if (val < 12) val = 12;
            if (val > 22) val = 22;

            if(fsRange) fsRange.value = val;
            htmlEl.style.fontSize = val + 'px';
            localStorage.setItem('client_global_fontsize', val);

            if(descFont) descFont.innerText = `Kích thước hiện tại: ${val}px`;
        };

        // Load init
        const savedFs = localStorage.getItem('client_global_fontsize') || '16';
        applyFontSize(parseInt(savedFs));

        // Event: Kéo slider
        if(fsRange) {
            fsRange.addEventListener('input', (e) => {
                applyFontSize(parseInt(e.target.value));
            });
        }

        // Event: Click chữ 'a' nhỏ (Giảm)
        if(btnDecrease) {
            btnDecrease.addEventListener('click', () => {
                const current = parseInt(fsRange.value || 16);
                applyFontSize(current - 1);
            });
        }

        // Event: Click chữ 'A' lớn (Tăng)
        if(btnIncrease) {
            btnIncrease.addEventListener('click', () => {
                const current = parseInt(fsRange.value || 16);
                applyFontSize(current + 1);
            });
        }

        // --- 4. MENU VIEW TOGGLE (CLIENT) ---
        const viewBtn = document.getElementById('settings-view-toggle');
        const viewIcon = viewBtn ? viewBtn.querySelector('i') : null;
        const descView = document.getElementById('desc-view');

        function updateViewStatus(mode) {
            if(viewIcon) {
                if(mode === 'grid') {
                    viewIcon.className = 'fa-solid fa-table-cells';
                    if(descView) descView.innerText = 'Đang hiển thị dạng lưới (Grid)';
                } else {
                    viewIcon.className = 'fa-solid fa-list-ul';
                    if(descView) descView.innerText = 'Đang hiển thị dạng danh sách (List)';
                }
            }
        }

        const savedView = localStorage.getItem('client_menu_view') || 'list';
        updateViewStatus(savedView);

        if(viewBtn) {
            viewBtn.addEventListener('click', (e) => {
                e.preventDefault();
                let current = localStorage.getItem('client_menu_view') || 'list';
                let newState = current === 'grid' ? 'list' : 'grid';

                localStorage.setItem('client_menu_view', newState);
                updateViewStatus(newState);

                const menuContainer = document.getElementById('menu-container');
                if(menuContainer) {
                    if(newState === 'grid') {
                        menuContainer.classList.remove('view-mode-list');
                        menuContainer.classList.add('view-mode-grid');
                    } else {
                        menuContainer.classList.remove('view-mode-grid');
                        menuContainer.classList.add('view-mode-list');
                    }
                }
            });
        }

        // --- 5. ENTER TO SEND LOGIC (CLIENT) ---
        const enterSwitch = document.getElementById('settings-enter-send');
        const descEnter = document.getElementById('desc-enter');

        const updateEnterText = (isOn) => {
            if(descEnter) descEnter.innerText = isOn ? 'Đang BẬT: Nhấn Enter để gửi' : 'Đang TẮT: Nhấn nút để gửi';
        };

        const savedEnter = localStorage.getItem('client_chat_enter_to_send') === 'true';
        if(enterSwitch) {
            enterSwitch.checked = savedEnter;
            updateEnterText(savedEnter);
        }

        if(enterSwitch) {
            enterSwitch.addEventListener('change', (e) => {
                const isEnabled = e.target.checked;
                localStorage.setItem('client_chat_enter_to_send', isEnabled);
                updateEnterText(isEnabled);
                if(window.updateChatConversationSettings) window.updateChatConversationSettings();
            });
        }

        // --- 6. RESET MENU ORDER (CLIENT) ---
        const btnResetMenu = document.getElementById('settings-reset-menu');
        if(btnResetMenu) {
            btnResetMenu.addEventListener('click', () => {
                if(typeof window.showConfirm === 'function') {
                    window.showConfirm(
                        'Đặt lại menu?',
                        'Vị trí sắp xếp các biểu tượng sẽ quay về mặc định.',
                        function() {
                            Object.keys(localStorage).forEach(key => {
                                if (key.startsWith('client_menu_order_')) localStorage.removeItem(key);
                            });
                            window.location.reload();
                        },
                        { confirmText: 'Đặt lại ngay', confirmColor: 'danger' }
                    );
                } else {
                    if(confirm('Bạn có chắc muốn đặt lại vị trí menu không?')) {
                        Object.keys(localStorage).forEach(key => {
                            if (key.startsWith('client_menu_order_')) localStorage.removeItem(key);
                        });
                        window.location.reload();
                    }
                }
            });
        }
    });
</script>
