<div id="bubble-wrapper" style="position: fixed; bottom: 1.875rem; right: 1.875rem; z-index: 10000;">
    {{-- 3 BONG BÓNG CON --}}
    <div class="sub-bubbles-container">
        <div class="sub-bubble" id="btn-open-menu" title="Menu chức năng">
            <i class="fa-solid fa-table-cells"></i>
        </div>
        <div class="sub-bubble" id="btn-open-chat" title="Tin nhắn">
            <i class="fa-solid fa-comments"></i>
            {{-- Badge đếm số lượng --}}
            <span class="badge-counter">1</span>
        </div>
        <div class="sub-bubble" id="btn-open-settings" title="Cài đặt">
            <i class="fa-solid fa-gear"></i>
        </div>
    </div>

    {{-- BONG BÓNG CHÍNH --}}
    <div id="nav-bubble" title="Mở rộng">
        {{-- Icon sẽ xoay riêng biệt --}}
        <i class="fa-solid fa-bars" id="bubble-icon"></i>

        {{-- Chấm đỏ thông báo --}}
        <span class="main-bubble-badge"></span>
    </div>
</div>

<style>
    /* --- BIẾN MÀU --- */
    :root {
        --neon-primary: 0, 191, 255;
        --neon-danger: 255, 49, 49;

        --transition-speed: 0.3s;
        --sub-bg: #ffffff;
        --sub-border: #d1d5db;
        --sub-text: #374151;
        --scrollbar-thumb: #cbd5e1;
    }

    body.dark-mode {
        --sub-bg: #1e293b;
        --sub-border: #334155;
        --sub-text: #f8fafc;
        --scrollbar-thumb: #334155;
    }

    /* WRAPPER */
    #bubble-wrapper {
        position: fixed; z-index: 10000;
        transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), opacity 0.3s ease, visibility 0.3s;
        opacity: 1; visibility: visible; transform: scale(1);
    }

    /* ẨN KHI SCROLL */
    #bubble-wrapper.scroll-hidden {
        transform: scale(0.9); opacity: 0; visibility: hidden; pointer-events: none;
    }

    /* --- BONG BÓNG CHÍNH --- */
    #nav-bubble {
        width: 3.75rem; height: 3.75rem;
        background: linear-gradient(135deg, #0ea5e9, #0284c7);
        color: #fff; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; cursor: pointer; position: relative; z-index: 10;
        transition: all var(--transition-speed) ease;

        /* Viền mỏng 1px */
        border: 0.0625rem solid transparent;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.2);
    }

    /* Hiệu ứng Glow mặc định (khi chưa tắt Neon) */
    #nav-bubble:not(.no-hover-glow):hover {
        transform: scale(1.05);
        border-color: #fff;
        box-shadow:
            0 0 0.1rem rgb(var(--neon-primary)) inset,
            0 0 0.5rem rgb(var(--neon-primary)) inset,
            0 0 1rem rgb(var(--neon-primary)),
            0 0 2.5rem rgb(var(--neon-primary));
    }

    #nav-bubble:not(.no-hover-glow):hover #bubble-icon {
        filter: drop-shadow(0 0 0.3rem rgb(var(--neon-primary)));
    }

    /* --- [QUAN TRỌNG] CLASS TẮT NEON --- */

    /* 1. Tắt bóng xanh (Blue Mode) */
    body.neon-off #nav-bubble {
        box-shadow: 0 5px 15px rgba(0,0,0,0.2) !important; /* Bóng đen mờ thường */
        border-color: transparent !important;
        animation: none !important;
    }

    /* 2. Tắt bóng đỏ (Red Mode - Menu Open) */
    body.neon-off #nav-bubble.red-mode {
        background: linear-gradient(135deg, #ef4444, #dc2626) !important;
        box-shadow: 0 5px 15px rgba(220, 38, 38, 0.4) !important;
        border-color: transparent !important;
    }

    /* 3. XỬ LÝ BONG BÓNG CON KHI TẮT NEON (THEO YÊU CẦU CỦA BẠN) */
    body.neon-off .sub-bubble.active {
        /* GIỮ NGUYÊN KÍCH THƯỚC TO (QUAN TRỌNG) */
        transform: scale(1.15) !important;

        /* THAY ĐỔI VIỀN THÀNH MÀU TRẮNG */
        border: 0.0625rem solid #fff !important;

        /* Giữ màu nền xanh active */
        background: linear-gradient(135deg, #0ea5e9, #0284c7) !important;
        color: #fff !important;

        /* Tắt hiệu ứng phát sáng neon, chỉ để bóng đổ thường */
        box-shadow: 0 5px 15px rgba(0,0,0,0.2) !important;
    }

    /* 4. Tắt hiệu ứng Glow của Icon bên trong */
    body.neon-off #nav-bubble #bubble-icon,
    body.neon-off #nav-bubble.red-mode #bubble-icon,
    body.neon-off .sub-bubble.active i {
        filter: none !important;
    }

    /* 5. Hover khi tắt Neon (Vẫn scale nhẹ để biết là nút bấm nhưng không sáng) */
    body.neon-off #nav-bubble:hover,
    body.neon-off .sub-bubble:hover {
        transform: scale(1.05) !important;
        box-shadow: 0 5px 15px rgba(0,0,0,0.25) !important;
    }
    /* Riêng bong bóng active thì hover vẫn giữ nguyên scale to */
    body.neon-off .sub-bubble.active:hover {
        transform: scale(1.15) !important;
    }

    body.neon-off #nav-bubble.red-mode:hover {
        box-shadow: 0 5px 15px rgba(220, 38, 38, 0.5) !important;
    }


    /* --- TRẠNG THÁI RED MODE (GỐC) --- */
    #nav-bubble.red-mode {
        background: linear-gradient(135deg, #ef4444, #dc2626) !important;
        border-color: #fff !important;

        box-shadow:
            0 0 0.1rem rgb(var(--neon-danger)) inset,
            0 0 0.5rem rgb(var(--neon-danger)) inset,
            0 0 1.5rem rgb(var(--neon-danger)),
            0 0 3.5rem rgb(var(--neon-danger)) !important;

        transform: scale(1.1);
    }

    #nav-bubble.red-mode #bubble-icon {
        filter: drop-shadow(0 0 0.5rem rgb(var(--neon-danger)));
        transform: rotate(90deg);
    }

    #bubble-icon { transition: transform 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55); }

    /* --- CHẤM ĐỎ THÔNG BÁO --- */
    .main-bubble-badge {
        position: absolute; top: 0; right: 0;
        width: 1rem; height: 1rem;
        background-color: #ef4444;
        border: 0.0625rem solid #fff;
        border-radius: 50%; z-index: 11;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
        pointer-events: auto;
    }

    /* Khi tắt Neon thì chấm đỏ cũng tắt glow */
    body.neon-off .main-bubble-badge {
        box-shadow: 0 2px 4px rgba(0,0,0,0.2) !important;
        border-color: #fff !important;
    }

    .main-bubble-badge:hover {
        transform: scale(1.2);
        box-shadow:
            0 0 0.1rem rgb(var(--neon-danger)) inset,
            0 0 0.5rem rgb(var(--neon-danger)),
            0 0 1rem rgb(var(--neon-danger));
        border-color: #fff;
    }

    /* --- SỐ ĐẾM TIN NHẮN --- */
    .badge-counter {
        position: absolute; top: -0.3rem; right: -0.3rem;
        background: #ef4444; color: white;
        font-size: 0.65rem; padding: 0.15rem 0.4rem;
        border-radius: 1rem; font-weight: bold;
        border: 0.0625rem solid #fff;
        box-shadow: 0 0 0.3rem rgba(255, 49, 49, 0.6);
    }

    /* --- SUB BUBBLES --- */
    .sub-bubbles-container {
        position: absolute; left: 0; width: 3.75rem;
        display: flex; flex-direction: column; align-items: center; gap: 1rem;
        pointer-events: none; z-index: 1;
    }

    .sub-bubble {
        width: 3.125rem; height: 3.125rem;
        background-color: var(--sub-bg);
        border: 0.0625rem solid var(--sub-border); /* Viền mỏng */
        color: var(--sub-text);
        backdrop-filter: blur(0.6rem); border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.25rem;
        cursor: pointer; opacity: 0; transform: scale(0);
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        position: relative;
    }

    .sub-bubble:not(.active):hover { transform: scale(1.1) !important; }

    /* Sub-bubble Active (Trạng thái bình thường - Có Neon) */
    .sub-bubble.active {
        background: linear-gradient(135deg, #0ea5e9, #0284c7) !important;
        border: 0.0625rem solid #fff !important; /* Viền mỏng 1px */
        color: #fff !important;
        transform: scale(1.15) !important;
        box-shadow:
            0 0 0.1rem rgb(var(--neon-primary)) inset,
            0 0 0.5rem rgb(var(--neon-primary)) inset,
            0 0 1rem rgb(var(--neon-primary)),
            0 0 2.5rem rgb(var(--neon-primary)) !important;
    }
    .sub-bubble.active i { filter: drop-shadow(0 0 0.3rem rgb(var(--neon-primary))); }

    /* --- POPUP (FIX TRÀN MÀN HÌNH) --- */
    #nav-popup {
        position: fixed; z-index: 9999; background: var(--popup-bg);
        backdrop-filter: blur(1rem); border: 0.0625rem solid var(--popup-border);
        box-shadow: var(--popup-shadow);
        border-radius: 1.25rem !important; overflow: hidden !important;
        overflow-y: auto !important; -webkit-overflow-scrolling: touch;
        opacity: 0; visibility: hidden; transform: scale(0.95);
        transition: opacity 0.2s, transform 0.2s;
        width: fit-content; max-width: 95vw; display: flex; flex-direction: column;
        scrollbar-width: thin;
        scrollbar-color: var(--scrollbar-thumb) transparent;
    }

    #nav-popup::-webkit-scrollbar { width: 4px; }
    #nav-popup::-webkit-scrollbar-thumb { background-color: var(--scrollbar-thumb); border-radius: 4px; }
    #nav-popup.active { opacity: 1; visibility: visible; transform: scale(1); }

    /* BACKDROP */
    #nav-backdrop {
        position: fixed; inset: 0; background: rgba(0,0,0,0.3); z-index: 9998;
        opacity: 0; visibility: hidden; transition: 0.3s; backdrop-filter: blur(2px);
    }
    #nav-backdrop.active { opacity: 1; visibility: visible; }

    #bubble-wrapper.expanded .sub-bubble { opacity: 1; transform: scale(1); pointer-events: auto; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const wrapper = document.getElementById('bubble-wrapper');
        const mainBubble = document.getElementById('nav-bubble');
        const subBubblesContainer = wrapper.querySelector('.sub-bubbles-container');
        const popup = document.getElementById('nav-popup');
        const backdrop = document.getElementById('nav-backdrop');
        const icon = document.getElementById('bubble-icon');
        const btns = {
            menu: document.getElementById('btn-open-menu'),
            chat: document.getElementById('btn-open-chat'),
            settings: document.getElementById('btn-open-settings')
        };
        const allBubbles = [mainBubble, btns.menu, btns.chat, btns.settings];

        window.isSystemOpen = false;
        window.currentPopupMode = 'menu';

        // --- 1. LOGIC NEON AUTO OFF (STRICT CLICK MODE) ---
        let neonTimeout;

        // Hàm bắt đầu đếm ngược 5s
        const startNeonCountdown = () => {
            // Chỉ chạy nếu tính năng đang bật trong cài đặt
            if(localStorage.getItem('client_neon_auto_off') === 'true') {
                clearTimeout(neonTimeout);
                neonTimeout = setTimeout(() => {
                    document.body.classList.add('neon-off');
                }, 5000);
            }
        };

        // Hàm "Đánh thức" Neon (Chỉ gọi khi CLICK)
        const wakeUpNeon = () => {
            // 1. Sáng đèn ngay lập tức
            document.body.classList.remove('neon-off');
            // 2. Reset và đếm lại 5s
            startNeonCountdown();
        };

        // Hàm khởi tạo Global (được gọi từ settings-popup)
        window.initNeonEffect = function() {
            const isAutoOff = localStorage.getItem('client_neon_auto_off') === 'true';
            clearTimeout(neonTimeout);

            if (!isAutoOff) {
                // Nếu tắt tính năng -> Luôn sáng
                document.body.classList.remove('neon-off');
            } else {
                // Nếu bật tính năng -> Bắt đầu đếm ngay từ lúc bật
                startNeonCountdown();
            }
        };

        // Gán sự kiện CLICK cho tất cả bong bóng
        // LƯU Ý: Chỉ dùng 'click' để tránh hiện tượng nháy sáng (flash) khi chuyển bong bóng
        allBubbles.forEach(bubble => {
            if(bubble) {
                bubble.addEventListener('click', wakeUpNeon);
            }
        });

        // Chạy lần đầu
        window.initNeonEffect();


        // --- 2. POSITION RESTORE ---
        let isDragging = false, startX, startY, initialLeft, initialTop;
        const restorePosition = () => {
            const savedPos = localStorage.getItem('client_bubblePos');
            if (savedPos) {
                try {
                    const pos = JSON.parse(savedPos);
                    let left = parseFloat(pos.left), top = parseFloat(pos.top);
                    const winW = window.innerWidth, winH = window.innerHeight, bubbleSize = 60;
                    if (isNaN(left) || isNaN(top)) return;
                    left = Math.min(Math.max(0, left), winW - bubbleSize);
                    top = Math.min(Math.max(0, top), winH - bubbleSize);
                    wrapper.style.left = left + 'px'; wrapper.style.top = top + 'px';
                    wrapper.style.bottom = 'auto'; wrapper.style.right = 'auto';
                } catch (e) { localStorage.removeItem('client_bubblePos'); }
            }
        };
        restorePosition();

        window.addEventListener('resize', () => {
            if(!isDragging && wrapper.style.left) {
                const r = wrapper.getBoundingClientRect();
                const winW = window.innerWidth, winH = window.innerHeight;
                let newLeft = r.left, newTop = r.top;
                if (newLeft + r.width > winW) newLeft = winW - r.width - 10;
                if (newTop + r.height > winH) newTop = winH - r.height - 10;
                wrapper.style.left = Math.max(0, newLeft) + 'px'; wrapper.style.top = Math.max(0, newTop) + 'px';
            }
            if (window.isSystemOpen) window.positionPopup(window.currentPopupMode);
        });

        const getPos = (e) => e.touches ? e.touches[0] : e;
        const onDragStart = (e) => {
            // Drag cũng được coi là tương tác -> Wake up neon
            wakeUpNeon();

            isDragging = false; const p = getPos(e); startX = p.clientX; startY = p.clientY;
            const r = wrapper.getBoundingClientRect(); initialLeft = r.left; initialTop = r.top;
            Object.assign(wrapper.style, { left: r.left + 'px', top: r.top + 'px', bottom: 'auto', right: 'auto', transition: 'none' });
            document.body.classList.add('no-select');
            document.addEventListener('mousemove', onDragMove); document.addEventListener('mouseup', onDragEnd);
            document.addEventListener('touchmove', onDragMove, { passive: false }); document.addEventListener('touchend', onDragEnd);
        };
        const onDragMove = (e) => {
            const p = getPos(e);
            if (Math.abs(p.clientX - startX) > 5 || Math.abs(p.clientY - startY) > 5) {
                isDragging = true; e.preventDefault();
                let nL = initialLeft + (p.clientX - startX), nT = initialTop + (p.clientY - startY);
                nL = Math.min(Math.max(0, nL), window.innerWidth - wrapper.offsetWidth);
                nT = Math.min(Math.max(0, nT), window.innerHeight - wrapper.offsetHeight);
                wrapper.style.left = `${nL}px`; wrapper.style.top = `${nT}px`;
                if (window.isSystemOpen) { expandBubblesVisual(); window.positionPopup(window.currentPopupMode); }
            }
        };
        const onDragEnd = () => {
            document.removeEventListener('mousemove', onDragMove); document.removeEventListener('mouseup', onDragEnd);
            document.removeEventListener('touchmove', onDragMove); document.removeEventListener('touchend', onDragEnd);
            document.body.classList.remove('no-select'); wrapper.style.transition = '';
            if (isDragging) { localStorage.setItem('client_bubblePos', JSON.stringify({ left: wrapper.style.left, top: wrapper.style.top })); setTimeout(() => isDragging = false, 50); }
        };
        mainBubble.addEventListener('mousedown', onDragStart);
        mainBubble.addEventListener('touchstart', onDragStart, { passive: false });

        mainBubble.onclick = () => { if (!isDragging) window.isSystemOpen ? closeAll() : openAll('menu'); };

        window.openAll = (mode) => {
            // Click mở menu -> Wake up
            wakeUpNeon();

            window.isSystemOpen = true; window.currentPopupMode = mode;
            expandBubblesVisual();
            if(mode === 'menu' && typeof window.renderMenuContent === 'function') window.renderMenuContent();
            if(mode === 'chat' && typeof window.renderChatConversationContent === 'function') window.renderChatConversationContent();
            if(mode === 'settings' && typeof window.renderSettingsContent === 'function') window.renderSettingsContent();

            wrapper.classList.add('expanded');
            icon.classList.replace('fa-bars', 'fa-xmark');
            backdrop.classList.add('active');
            popup.classList.add('active');
            mainBubble.classList.add('red-mode');

            highlight(mode); setTimeout(() => window.positionPopup(mode), 10);
        };

        window.closeAll = () => {
            // Click đóng menu -> Wake up
            wakeUpNeon();

            window.isSystemOpen = false; wrapper.classList.remove('expanded'); popup.classList.remove('active');
            icon.classList.replace('fa-xmark', 'fa-bars'); backdrop.classList.remove('active');
            mainBubble.classList.remove('red-mode');
            highlight(null);
        };

        const highlight = (mode) => { Object.values(btns).forEach(b => b?.classList.remove('active')); if (btns[mode]) btns[mode].classList.add('active'); };

        window.expandBubblesVisual = () => {
            const r = wrapper.getBoundingClientRect(); const sw = window.innerWidth; const sh = window.innerHeight;
            const isMobile = sw < 998;
            subBubblesContainer.style.cssText = 'position: absolute; display: flex; gap: 1rem; pointer-events: none;';
            if (isMobile) {
                subBubblesContainer.style.flexDirection = 'row'; subBubblesContainer.style.top = '0.3rem'; subBubblesContainer.style.width = 'max-content';
                if (r.left > sw / 2) { subBubblesContainer.style.right = '4.5rem'; subBubblesContainer.style.left = 'auto'; subBubblesContainer.style.justifyContent = 'flex-end'; }
                else { subBubblesContainer.style.left = '4.5rem'; subBubblesContainer.style.right = 'auto'; subBubblesContainer.style.justifyContent = 'flex-start'; }
            } else {
                subBubblesContainer.style.width = '3.75rem'; subBubblesContainer.style.left = '0'; subBubblesContainer.style.flexDirection = 'column';
                r.top > sh / 2 ? (subBubblesContainer.style.bottom = '4.5rem', subBubblesContainer.style.top = 'auto') : (subBubblesContainer.style.top = '4.5rem', subBubblesContainer.style.bottom = 'auto');
            }
        };

        // --- LOGIC VỊ TRÍ POPUP ---
        window.positionPopup = (type) => {
            const r = wrapper.getBoundingClientRect();
            const sw = window.innerWidth;
            const sh = window.innerHeight;
            const gap = 15;

            popup.style.left = ''; popup.style.right = ''; popup.style.top = ''; popup.style.bottom = '';

            if (sw < 998) {
                popup.style.width = '90vw'; popup.style.left = '50%'; popup.style.transform = 'translateX(-50%)';
                if (r.top > sh / 2) {
                    let availableHeight = r.top - gap - gap;
                    popup.style.maxHeight = availableHeight + 'px';
                    popup.style.bottom = (sh - r.top + gap) + 'px';
                } else {
                    let availableHeight = sh - r.bottom - gap - gap;
                    popup.style.maxHeight = availableHeight + 'px';
                    popup.style.top = (r.bottom + gap) + 'px';
                }
            } else {
                if (r.left > sw / 2) popup.style.right = (sw - r.left + gap) + 'px';
                else popup.style.left = (r.right + gap) + 'px';
                popup.style.maxHeight = (sh - (gap * 2)) + 'px';
                const ph = popup.offsetHeight;
                let finalTop = r.top;
                if (r.top >= sh / 2) finalTop = r.bottom - ph;
                if (finalTop + ph > sh - gap) finalTop = sh - ph - gap;
                if (finalTop < gap) finalTop = gap;
                popup.style.top = finalTop + 'px';
            }
        };

        btns.menu?.addEventListener('click', (e) => { e.stopPropagation(); openAll('menu'); });
        btns.chat?.addEventListener('click', (e) => { e.stopPropagation(); openAll('chat'); });
        btns.settings?.addEventListener('click', (e) => { e.stopPropagation(); openAll('settings'); });
    });
</script>
