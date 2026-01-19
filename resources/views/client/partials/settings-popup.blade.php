<div id="settings-interface" class="d-none">
    <style>
        /* --- CSS CHO SETTINGS POPUP (CLIENT) --- */
        #settings-interface {
            width: 420px;
            max-width: 100%;
            padding: 25px;
            display: flex;
            flex-direction: column;
            gap: 20px;

            /* --- SCROLL LOGIC --- */
            max-height: 80vh;
            overflow-y: auto;
            overscroll-behavior: contain;
            scrollbar-width: thin;
        }

        /* Scrollbar styling */
        #settings-interface::-webkit-scrollbar { width: 6px; }
        #settings-interface::-webkit-scrollbar-track { background: transparent; }
        #settings-interface::-webkit-scrollbar-thumb { background-color: var(--scrollbar-thumb); border-radius: 10px; }

        /* Responsive Mobile */
        @media (max-width: 998px) {
            #settings-interface {
                width: 92vw;
                padding: 20px;
                max-height: 75vh;
            }
        }

        .settings-header {
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--text-color);
            border-bottom: 2px solid var(--popup-border);
            padding-bottom: 12px;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .settings-group {
            background: rgba(127, 127, 127, 0.05);
            border-radius: 16px;
            padding: 18px;
            border: 1px solid var(--popup-border);
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

        /* Components */
        .form-switch .form-check-input {
            width: 3.2em; height: 1.6em; cursor: pointer; border-color: var(--popup-border);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='rgba%280, 0, 0, 0.25%29'/%3e%3c/svg%3e");
        }
        .form-switch .form-check-input:checked {
            background-color: var(--primary); border-color: var(--primary);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%23fff'/%3e%3c/svg%3e");
        }

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

        /* Slider */
        #settings-fontsize-range { cursor: pointer; height: 6px; width: 120px; }
        #settings-fontsize-range::-webkit-slider-runnable-track { background: var(--input-darker); height: 6px; border-radius: 10px; border: 1px solid var(--popup-border); }
        #settings-fontsize-range::-webkit-slider-thumb { margin-top: -6px; background: var(--primary); box-shadow: 0 0 10px rgba(var(--primary), 0.4); border: 2px solid #fff; height: 18px; width: 18px; transition: transform 0.1s ease; -webkit-appearance: none; border-radius: 50%; }

        /* Theme Toggle CSS */
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

    <div class="settings-header">
        <i class="fa-solid fa-gears text-primary"></i> CÀI ĐẶT
    </div>

    {{-- NHÓM 1: GIAO DIỆN --}}
    <div class="settings-group">
        <div class="settings-group-title">Giao diện & Hiển thị</div>

        {{-- 1.1 Chế độ tối --}}
        <div class="setting-item">
            <div class="setting-info">
                <div class="setting-label"><i class="fa-solid fa-circle-half-stroke text-muted"></i> Chế độ tối</div>
                <div class="setting-subtext" id="desc-theme">Đang sử dụng chế độ sáng</div>
            </div>
            <div class="theme-switch-wrapper">
                <label for="settings-theme-toggle" class="theme">
                    <span class="theme__toggle-wrap">
                        <input id="settings-theme-toggle" class="theme__toggle" type="checkbox" role="switch">
                        <span class="theme__icon">
                            <span class="theme__icon-part"></span><span class="theme__icon-part"></span><span class="theme__icon-part"></span><span class="theme__icon-part"></span>
                            <span class="theme__icon-part"></span><span class="theme__icon-part"></span><span class="theme__icon-part"></span><span class="theme__icon-part"></span><span class="theme__icon-part"></span>
                        </span>
                    </span>
                </label>
            </div>
        </div>

        {{-- 1.2 Cỡ chữ --}}
        <div class="setting-item">
            <div class="setting-info">
                <div class="setting-label"><i class="fa-solid fa-text-height text-muted"></i> Cỡ chữ</div>
                <div class="setting-subtext" id="desc-font">Kích thước hiện tại: 16px</div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <small class="text-muted" style="font-size: 0.7rem;">A</small>
                <input type="range" class="form-range" id="settings-fontsize-range" min="12" max="22" step="1" value="16">
                <span class="text-primary fw-bold" style="font-size: 1rem;">A</span>
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

        {{-- 2.1 Phím Enter để gửi --}}
        <div class="setting-item">
            <div class="setting-info">
                <div class="setting-label"><i class="fa-solid fa-keyboard text-muted"></i> Enter để gửi</div>
                <div class="setting-subtext" id="desc-enter">Gửi tin nhắn bằng phím Enter</div>
            </div>
            <div class="form-check form-switch mb-0">
                <input class="form-check-input" type="checkbox" role="switch" id="settings-enter-send">
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
        const htmlEl = document.documentElement;

        const updateFontText = (val) => {
            if(descFont) descFont.innerText = `Kích thước hiện tại: ${val}px`;
        };

        const savedFs = localStorage.getItem('client_global_fontsize') || '16';
        if(fsRange) {
            fsRange.value = savedFs;
            htmlEl.style.fontSize = savedFs + 'px';
            updateFontText(savedFs);

            fsRange.addEventListener('input', (e) => {
                const val = e.target.value;
                htmlEl.style.fontSize = val + 'px';
                localStorage.setItem('client_global_fontsize', val);
                updateFontText(val);
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
                if(window.updateChatSettings) window.updateChatSettings();
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
