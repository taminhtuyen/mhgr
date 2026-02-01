<div id="settings-interface" class="d-none">
    <style>
        /* CORE LAYOUT */
        #settings-interface { width: 420px; max-width: 100%; padding: 0; display: flex; flex-direction: column; gap: 20px; max-height: 80vh; overflow-y: auto; overscroll-behavior: contain; scrollbar-width: thin; }
        #settings-interface::-webkit-scrollbar { width: 6px; }
        #settings-interface::-webkit-scrollbar-track { background: transparent; }
        #settings-interface::-webkit-scrollbar-thumb { background-color: var(--scrollbar-thumb); border-radius: 10px; }
        @media (max-width: 998px) { #settings-interface { width: 92vw; padding: 0; max-height: 75vh; } }

        /* HEADER */
        .settings-header {
            font-size: 1.2rem; font-weight: 800; color: var(--text-color); border-bottom: 2px solid var(--popup-border);
            position: sticky; top: 0; z-index: 50; background-color: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); padding: 20px 25px 15px 25px;
            margin-bottom: 5px; display: flex; align-items: center; gap: 12px; flex-shrink: 0;
        }
        body.dark-mode .settings-header { background-color: rgba(15, 23, 42, 0.85); }

        /* GROUP & ITEM */
        .settings-group { background: rgba(127, 127, 127, 0.05); border-radius: 16px; padding: 18px; border: 1px solid var(--popup-border); margin: 0 25px; }
        .settings-group:last-child { margin-bottom: 25px; }
        .settings-group-title { font-size: 0.75rem; text-transform: uppercase; color: var(--text-muted); font-weight: 800; margin-bottom: 15px; letter-spacing: 0.5px; opacity: 0.8; }
        .setting-item { display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; }
        .setting-item:last-child { margin-bottom: 0; }
        .setting-info { display: flex; flex-direction: column; }
        .setting-label { font-size: 0.95rem; font-weight: 600; color: var(--text-color); display: flex; align-items: center; gap: 8px; line-height: 1.4; }
        .setting-subtext { font-size: 0.75rem; color: var(--text-muted); margin-top: 2px; margin-left: 24px; font-weight: 400; }

        /* THEME SWITCH */
        .switch-theme { font-size: 1.0625rem; position: relative; display: inline-block; width: 3.5em; height: 2em; }
        .switch-theme input { opacity: 0; width: 0; height: 0; }
        .slider-theme { background-color: #2185d6; position: absolute; top: 0; left: 0; right: 0; bottom: 0; cursor: pointer; border-radius: 30px; transition: all 0.4s ease; }
        .slider-theme::before { position: absolute; content: ""; height: 1.4em; width: 1.4em; border-radius: 50%; left: 10%; bottom: 15%; background-color: #28096b; transition: all 0.4s ease; box-shadow: inset 15px -4px 0px 15px #fdf906; }
        .switch-theme input:checked + .slider-theme { background-color: #28096b !important; }
        .switch-theme input:checked + .slider-theme::before { transform: translateX(100%); box-shadow: inset 8px -4px 0 0 #fff; }

        /* NEON SWITCH 3 STATE (GIỐNG CLIENT) */
        .neon-switch-3state { position: relative; display: inline-flex; width: 150px; height: 32px; background: rgba(127,127,127,0.1); border-radius: 8px; overflow: hidden; border: 1px solid var(--popup-border); cursor: pointer; }
        .neon-state-option { flex: 1; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 600; color: var(--text-muted); z-index: 2; transition: color 0.3s; }
        .neon-slider-bg { position: absolute; top: 2px; bottom: 2px; width: 32%; background: #fff; border-radius: 6px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); transition: left 0.3s cubic-bezier(0.4, 0.0, 0.2, 1); z-index: 1; }
        body.dark-mode .neon-slider-bg { background: #334155; }

        /* State Positions */
        .neon-switch-3state[data-state="0"] .neon-slider-bg { left: 2px; }
        .neon-switch-3state[data-state="1"] .neon-slider-bg { left: 34%; }
        .neon-switch-3state[data-state="2"] .neon-slider-bg { left: 66%; }

        .neon-switch-3state[data-state="0"] .opt-0 { color: var(--text-color); }
        .neon-switch-3state[data-state="1"] .opt-1 { color: #0ea5e9; }
        .neon-switch-3state[data-state="2"] .opt-2 { color: #22c55e; }

        /* OTHER CONTROLS */
        .btn-view-toggle { width: 42px; height: 42px; border-radius: 12px; border: 1px solid var(--popup-border); background: var(--bg-body); color: var(--text-muted); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; transition: all 0.2s; cursor: pointer; }
        .btn-view-toggle:hover { background: var(--primary); color: #fff; border-color: var(--primary); transform: scale(1.05); }
        .btn-reset-menu { border: 1px solid rgba(239, 68, 68, 0.3); background: rgba(239, 68, 68, 0.05); color: #ef4444; padding: 8px 12px; border-radius: 8px; font-size: 0.85rem; font-weight: 600; cursor: pointer; transition: 0.2s; display: flex; align-items: center; gap: 6px; }
        .btn-reset-menu:hover { background: #ef4444; color: #fff; }
        .toggle-switch-lite { display: inline-block; position: relative; width: 50px; height: 30px; }
        .toggle-input-lite { display: none; }
        .toggle-label-lite { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: #e9e9eb; border-radius: 34px; cursor: pointer; transition: background-color 0.3s; }
        .toggle-label-lite:before { content: ""; position: absolute; top: 2px; left: 2px; width: 26px; height: 26px; background-color: #fff; border-radius: 50%; transition: transform 0.3s cubic-bezier(0.4, 0.0, 0.2, 1); box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .toggle-input-lite:checked + .toggle-label-lite { background-color: #34C759; }
        .toggle-input-lite:checked + .toggle-label-lite:before { transform: translateX(20px); }
        body.dark-mode .toggle-label-lite { background-color: rgba(255, 255, 255, 0.15); border: 1px solid rgba(255, 255, 255, 0.05); }
    </style>

    <div class="settings-header">
        <div class="d-flex align-items-center gap-2"><i class="fa-solid fa-gears text-primary"></i> CÀI ĐẶT</div>
        <button class="btn btn-sm btn-icon text-muted ms-auto bg-transparent border-0" onclick="closeAll()" title="Đóng"><i class="fa-solid fa-xmark" style="font-size: 1.2rem;"></i></button>
    </div>

    {{-- NHÓM 1: GIAO DIỆN --}}
    <div class="settings-group">
        <div class="settings-group-title">Giao diện & Hiển thị</div>

        {{-- Theme --}}
        <div class="setting-item">
            <div class="setting-info">
                <div class="setting-label"><i class="fa-solid fa-circle-half-stroke text-muted"></i> Chế độ tối</div>
                <div class="setting-subtext" id="desc-theme">Chế độ sáng</div>
            </div>
            <label class="switch-theme">
                <input type="checkbox" id="settings-theme-toggle">
                <span class="slider-theme"></span>
            </label>
        </div>

        {{-- NEON MODE 3 STATE (SWITCH ĐƠN GIẢN CỦA CLIENT) --}}
        <div class="setting-item">
            <div class="setting-info">
                <div class="setting-label"><i class="fa-solid fa-lightbulb text-muted"></i> Đèn Neon</div>
                <div class="setting-subtext" id="desc-neon">Tự động (5s)</div>
            </div>
            <div class="neon-switch-3state" id="settings-neon-switch" data-state="1">
                <div class="neon-slider-bg"></div>
                <div class="neon-state-option opt-0">TẮT</div>
                <div class="neon-state-option opt-1">AUTO</div>
                <div class="neon-state-option opt-2">BẬT</div>
            </div>
        </div>

        {{-- Font Size --}}
        <div class="setting-item">
            <div class="setting-info">
                <div class="setting-label"><i class="fa-solid fa-text-height text-muted"></i> Cỡ chữ</div>
                <div class="setting-subtext" id="desc-font">16px</div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <small class="text-muted cursor-pointer" id="btn-decrease-font" style="font-size: 0.7rem;">A</small>
                <input type="range" class="form-range" id="settings-fontsize-range" min="12" max="22" step="1" value="16" style="width: 100px;">
                <span class="text-primary fw-bold cursor-pointer" id="btn-increase-font" style="font-size: 1rem;">A</span>
            </div>
        </div>

        {{-- Menu View --}}
        <div class="setting-item">
            <div class="setting-info">
                <div class="setting-label"><i class="fa-solid fa-table-layout text-muted"></i> Kiểu Menu</div>
                <div class="setting-subtext" id="desc-view">Danh sách</div>
            </div>
            <button class="btn-view-toggle" id="settings-view-toggle"><i class="fa-solid fa-list-ul"></i></button>
        </div>

        <div class="setting-item">
            <div class="setting-info">
                <div class="setting-label"><i class="fa-solid fa-arrow-rotate-left text-muted"></i> Sắp xếp</div>
                <div class="setting-subtext">Khôi phục mặc định</div>
            </div>
            <button class="btn-reset-menu" id="settings-reset-menu"><i class="fa-solid fa-rotate"></i> Đặt lại</button>
        </div>
    </div>

    {{-- NHÓM 2: NHẮN TIN --}}
    <div class="settings-group">
        <div class="settings-group-title">Trò chuyện</div>
        <div class="setting-item">
            <div class="setting-info">
                <div class="setting-label"><i class="fa-solid fa-keyboard text-muted"></i> Enter để gửi</div>
                <div class="setting-subtext" id="desc-enter">Bật</div>
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
        window.renderSettingsContent = function() {
            const menu = document.getElementById('menu-interface');
            const chat = document.getElementById('chat-interface');
            const settings = document.getElementById('settings-interface');
            if (menu) menu.classList.add('d-none');
            if (chat) chat.classList.add('d-none');
            if (settings) settings.classList.remove('d-none');
        }

        // --- THEME ---
        const themeToggle = document.getElementById('settings-theme-toggle');
        const descTheme = document.getElementById('desc-theme');
        const updateThemeText = (isDark) => { if(descTheme) descTheme.innerText = isDark ? 'Chế độ tối' : 'Chế độ sáng'; };

        if(localStorage.getItem('admin_theme_preference') === 'dark') { themeToggle.checked = true; updateThemeText(true); }
        themeToggle.addEventListener('change', (e) => {
            const isDark = e.target.checked;
            document.body.classList.toggle('dark-mode', isDark);
            localStorage.setItem('admin_theme_preference', isDark ? 'dark' : 'light');
            updateThemeText(isDark);
        });

        // --- NEON 3 STATE LOGIC ---
        const neonSwitch = document.getElementById('settings-neon-switch');
        const descNeon = document.getElementById('desc-neon');
        const neonStates = { 0: 'Đã tắt hoàn toàn', 1: 'Sáng khi chạm (5s)', 2: 'Luôn bật đèn' };

        let currentNeonState = localStorage.getItem('admin_neon_mode') || 1;

        const updateNeonUI = (state) => {
            state = parseInt(state);
            if(neonSwitch) neonSwitch.setAttribute('data-state', state);
            if(descNeon) descNeon.innerText = neonStates[state];
            if(typeof NeonManager !== 'undefined') NeonManager.setMode(state);
        };

        updateNeonUI(currentNeonState);

        if(neonSwitch) {
            neonSwitch.addEventListener('click', () => {
                currentNeonState = (parseInt(currentNeonState) + 1) % 3;
                updateNeonUI(currentNeonState);
            });
        }

        // --- FONT SIZE ---
        const fsRange = document.getElementById('settings-fontsize-range');
        const descFont = document.getElementById('desc-font');
        const applyFontSize = (val) => {
            if(fsRange) fsRange.value = val;
            document.documentElement.style.fontSize = val + 'px';
            localStorage.setItem('admin_global_fontsize', val);
            if(descFont) descFont.innerText = val + 'px';
        };
        const savedFs = localStorage.getItem('admin_global_fontsize') || '16';
        applyFontSize(parseInt(savedFs));

        fsRange.addEventListener('input', (e) => applyFontSize(e.target.value));
        document.getElementById('btn-decrease-font').addEventListener('click', () => applyFontSize(parseInt(fsRange.value) - 1));
        document.getElementById('btn-increase-font').addEventListener('click', () => applyFontSize(parseInt(fsRange.value) + 1));

        // --- MENU VIEW ---
        const viewBtn = document.getElementById('settings-view-toggle');
        const descView = document.getElementById('desc-view');
        const updateViewStatus = (mode) => {
            const icon = viewBtn.querySelector('i');
            if(mode === 'grid') { icon.className = 'fa-solid fa-table-cells'; descView.innerText = 'Lưới'; }
            else { icon.className = 'fa-solid fa-list-ul'; descView.innerText = 'Danh sách'; }
        };
        updateViewStatus(localStorage.getItem('admin_menu_view') || 'list');
        viewBtn.addEventListener('click', () => {
            const current = localStorage.getItem('admin_menu_view') || 'list';
            const newState = current === 'grid' ? 'list' : 'grid';
            localStorage.setItem('admin_menu_view', newState);
            updateViewStatus(newState);
            // Trigger update in menu-popup
            const menuContainer = document.getElementById('admin-menu-container');
            if(menuContainer) {
                menuContainer.classList.remove('view-mode-list', 'view-mode-grid');
                menuContainer.classList.add(newState === 'grid' ? 'view-mode-grid' : 'view-mode-list');
            }
        });

        // --- RESET MENU ---
        document.getElementById('settings-reset-menu')?.addEventListener('click', () => {
            if(confirm('Đặt lại vị trí menu?')) {
                Object.keys(localStorage).forEach(key => { if(key.startsWith('admin_menu_order_')) localStorage.removeItem(key); });
                window.location.reload();
            }
        });
    });
</script>
