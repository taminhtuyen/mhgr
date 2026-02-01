<div id="bubble-wrapper" style="position: fixed; bottom: 1.875rem; right: 1.875rem; z-index: 10000;">
    {{-- 3 BONG BÓNG CON --}}
    <div class="sub-bubbles-container">
        <div class="sub-bubble neon-target" id="btn-open-menu" title="Menu chức năng">
            <i class="fa-solid fa-table-cells"></i>
        </div>
        <div class="sub-bubble neon-target" id="btn-open-chat" title="Tin nhắn">
            <i class="fa-solid fa-comments"></i>
            {{-- Badge đếm số lượng --}}
            <span class="badge-counter">1</span>
        </div>
        <div class="sub-bubble neon-target" id="btn-open-settings" title="Cài đặt">
            <i class="fa-solid fa-gear"></i>
        </div>
    </div>

    {{-- BONG BÓNG CHÍNH --}}
    <div id="nav-bubble" class="neon-target" title="Mở rộng">
        {{-- Icon sẽ xoay riêng biệt --}}
        <i class="fa-solid fa-bars" id="bubble-icon"></i>

        {{-- Chấm đỏ thông báo --}}
        <span class="main-bubble-badge"></span>
    </div>
</div>

<style>
    /* --- 1. ĐỊNH NGHĨA BIẾN --- */
    :root {
        --c-blue: 0, 191, 255;
        --c-red: 255, 49, 49;
        --sub-bg: #ffffff;
        --sub-border: #d1d5db;
        --sub-text: #374151;
        --neon-duration: 0.5s;
    }

    body.dark-mode {
        --sub-bg: #1e293b;
        --sub-border: #334155;
        --sub-text: #f8fafc;
    }

    /* WRAPPER */
    #bubble-wrapper {
        position: fixed; z-index: 10000;
        transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), opacity 0.3s ease;
        opacity: 1; visibility: visible; transform: scale(1);
        transform: translateZ(0); will-change: transform;
    }
    #bubble-wrapper.scroll-hidden { transform: scale(0.9); opacity: 0; visibility: hidden; pointer-events: none; }

    /* =================================================================
       LOGIC BONG BÓNG CHÍNH (MAIN BUBBLE)
       ================================================================= */
    #nav-bubble {
        width: 3.75rem; height: 3.75rem;
        background: linear-gradient(135deg, #0ea5e9, #0284c7);
        color: #fff; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; cursor: pointer; position: relative; z-index: 10;
        border: 0.0625rem solid transparent;
        transform: scale(1);
        box-shadow: none;

        transition:
            transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1),
            background-color 0.3s ease,
            box-shadow 2.0s ease-out,
            border-color 2.0s ease-out;
    }

    /* Blue Glow (Tránh chồng lấn Red Mode) */
    #nav-bubble:not(.red-mode).hover-glow,
    body.neon-mode-2 #nav-bubble:not(.red-mode) {
        box-shadow: 0 0 0.1rem rgba(var(--c-blue), 1) inset, 0 0 0.5rem rgba(var(--c-blue), 1) inset, 0 0 1rem rgba(var(--c-blue), 1), 0 0 2.5rem rgba(var(--c-blue), 1), 0 0.5rem 1rem rgba(0, 0, 0, 0.2) !important;
        border-color: #fff;
        transition: box-shadow 0.2s ease-out, border-color 0.2s ease-out;
    }

    /* Red Mode (Vật lý - Màu nền) */
    #nav-bubble.red-mode {
        background: linear-gradient(135deg, #ef4444, #dc2626) !important;
        border-color: #fff !important;
    }

    /* Red Glow (Ánh sáng - Chỉ khi Neon Active) */
    body.neon-active #nav-bubble.red-mode,
    #nav-bubble.red-mode.hover-glow {
        box-shadow: 0 0 0.1rem rgba(var(--c-red), 1) inset, 0 0 0.5rem rgba(var(--c-red), 1) inset, 0 0 1.5rem rgba(var(--c-red), 1), 0 0 3.5rem rgba(var(--c-red), 1), 0 0.5rem 1rem rgba(0, 0, 0, 0.2) !important;
        transition: box-shadow 0.2s ease-out;
    }

    /* =================================================================
       LOGIC BONG BÓNG CON (SUB BUBBLES)
       ================================================================= */
    .sub-bubble {
        width: 3.125rem; height: 3.125rem;
        background-color: var(--sub-bg); border: 0.0625rem solid var(--sub-border); color: var(--sub-text);
        backdrop-filter: blur(0.6rem); border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.25rem; cursor: pointer; opacity: 0; transform: scale(0); position: relative;
        box-shadow: none;

        transition:
            transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1),
            background-color 0.3s ease,
            opacity 0.3s ease,
            color 0.3s ease,
            box-shadow 2.0s ease-out,
            border-color 2.0s ease-out;
    }

    /* 1. TRẠNG THÁI ACTIVE (VẬT LÝ - LUÔN GIỮ NỀN VÀ SCALE) */
    .sub-bubble.active {
        background: linear-gradient(135deg, #0ea5e9, #0284c7) !important;
        border: 0.0625rem solid #fff !important;
        color: #fff !important;
        transform: scale(1.15) !important;
        z-index: 10;
        opacity: 1 !important;
    }

    /* 2. TRẠNG THÁI ACTIVE (ÁNH SÁNG - CHỈ KHI CÓ ĐÈN) */
    body.neon-active .sub-bubble.active {
        box-shadow: 0 0 0.1rem rgba(var(--c-blue), 1) inset, 0 0 0.5rem rgba(var(--c-blue), 1) inset, 0 0 1rem rgba(var(--c-blue), 1), 0 0 2.5rem rgba(var(--c-blue), 1), 0 0.5rem 1rem rgba(0,0,0,0.2) !important;
        /* Khi đèn bật lại, shadow hiện nhanh 0.2s */
        transition: box-shadow 0.2s ease-out;
    }

    /* 3. TRẠNG THÁI HOVER CHƯA ACTIVE (CHỈ PHÓNG TO, KHÔNG GLOW) */
    #bubble-wrapper.expanded .sub-bubble:not(.active):hover {
        transform: scale(1.1) !important;
        background-color: var(--sub-bg) !important;
        color: var(--sub-text) !important;
        border-color: var(--sub-border) !important;
        z-index: 5;
        opacity: 1 !important;
        /* Box-shadow mặc định là none, không thêm gì ở đây */
    }

    /* ICON */
    #bubble-icon, .sub-bubble i { transition: filter 0.5s ease-out, transform 0.4s cubic-bezier(0.4, 0, 0.2, 1); filter: none; transform: rotate(0deg); }
    #nav-bubble.red-mode #bubble-icon { transform: rotate(90deg); }

    /* Icon Glow - CHỈ DÀNH CHO BONG BÓNG CHÍNH HOẶC BONG BÓNG CON ĐANG ACTIVE */
    /* Đã loại bỏ selector hover cho sub-bubble */
    #nav-bubble:not(.red-mode).hover-glow #bubble-icon,
    body.neon-mode-2 #nav-bubble:not(.red-mode) #bubble-icon,
    body.neon-active .sub-bubble.active i {
        filter: drop-shadow(0 0 0.3rem rgba(var(--c-blue), 1));
    }

    body.neon-active #nav-bubble.red-mode #bubble-icon,
    #nav-bubble.red-mode.hover-glow #bubble-icon {
        filter: drop-shadow(0 0 0.5rem rgba(var(--c-red), 1));
    }

    /* Layout & Badge */
    .main-bubble-badge { position: absolute; top: 0; right: 0; width: 1rem; height: 1rem; background-color: #ef4444; border: 0.0625rem solid #fff; border-radius: 50%; z-index: 11; box-shadow: 0 2px 4px rgba(0,0,0,0.2); pointer-events: none; transition: all 0.5s ease-out; }
    #nav-bubble.hover-glow .main-bubble-badge { box-shadow: 0 0 5px #ef4444; }
    .sub-bubbles-container { position: absolute; left: 0; width: 3.75rem; display: flex; flex-direction: column; align-items: center; gap: 1rem; pointer-events: none; z-index: 1; }
    #bubble-wrapper.expanded .sub-bubble { opacity: 1; transform: scale(1); pointer-events: auto; }

    /* Popup & Backdrop */
    #nav-popup { position: fixed; z-index: 9999; background: var(--popup-bg); backdrop-filter: blur(1rem); border: 0.0625rem solid var(--popup-border); box-shadow: var(--popup-shadow); border-radius: 1.25rem !important; overflow: hidden !important; overflow-y: auto !important; -webkit-overflow-scrolling: touch; opacity: 0; visibility: hidden; transform: scale(0.95); transition: opacity 0.2s, transform 0.2s; width: fit-content; max-width: 95vw; display: flex; flex-direction: column; scrollbar-width: thin; scrollbar-color: var(--scrollbar-thumb) transparent; }
    #nav-popup::-webkit-scrollbar { width: 4px; }
    #nav-popup::-webkit-scrollbar-thumb { background-color: var(--scrollbar-thumb); border-radius: 4px; }
    #nav-popup.active { opacity: 1; visibility: visible; transform: scale(1); }
    #nav-backdrop { position: fixed; inset: 0; background: rgba(0,0,0,0.3); z-index: 9998; opacity: 0; visibility: hidden; transition: 0.3s; backdrop-filter: blur(2px); }
    #nav-backdrop.active { opacity: 1; visibility: visible; }
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

        // --- BONG BÓNG CHÍNH ---
        mainBubble.addEventListener('mouseenter', () => {
            mainBubble.classList.add('hover-glow');
            if(window.NeonManager) window.NeonManager.wakeUp();
        });
        mainBubble.addEventListener('mouseleave', () => {
            mainBubble.classList.remove('hover-glow');
        });

        const otherTargets = document.querySelectorAll('.neon-target:not(#nav-bubble)');
        otherTargets.forEach(el => {
            el.addEventListener('mouseenter', () => { if(window.NeonManager) window.NeonManager.wakeUp(); });
            el.addEventListener('touchstart', () => { if(window.NeonManager) window.NeonManager.wakeUp(); }, {passive: true});
        });

        let isDragging = false, startX, startY, initialLeft, initialTop;
        const storageKeyPos = 'client_bubblePos';
        const restorePosition = () => {
            const savedPos = localStorage.getItem(storageKeyPos);
            if (savedPos) {
                try {
                    const pos = JSON.parse(savedPos);
                    let left = parseFloat(pos.left), top = parseFloat(pos.top);
                    const winW = window.innerWidth, winH = window.innerHeight, bubbleSize = 60;
                    if (!isNaN(left) && !isNaN(top)) {
                        left = Math.min(Math.max(0, left), winW - bubbleSize);
                        top = Math.min(Math.max(0, top), winH - bubbleSize);
                        wrapper.style.left = left + 'px'; wrapper.style.top = top + 'px';
                        wrapper.style.bottom = 'auto'; wrapper.style.right = 'auto';
                    }
                } catch (e) { localStorage.removeItem(storageKeyPos); }
            }
        };
        restorePosition();

        window.addEventListener('resize', () => {
            if(!isDragging && wrapper.style.left) {
                const r = wrapper.getBoundingClientRect();
                const winW = window.innerWidth, winH = window.innerHeight;
                let newLeft = Math.min(Math.max(0, r.left), winW - r.width);
                let newTop = Math.min(Math.max(0, r.top), winH - r.height);
                wrapper.style.left = newLeft + 'px'; wrapper.style.top = newTop + 'px';
            }
            if (window.isSystemOpen) window.positionPopup(window.currentPopupMode);
        });

        const getPos = (e) => e.touches ? e.touches[0] : e;
        const onDragStart = (e) => {
            mainBubble.classList.add('hover-glow');
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
                let nL = Math.min(Math.max(0, initialLeft + (p.clientX - startX)), window.innerWidth - wrapper.offsetWidth);
                let nT = Math.min(Math.max(0, initialTop + (p.clientY - startY)), window.innerHeight - wrapper.offsetHeight);
                wrapper.style.left = `${nL}px`; wrapper.style.top = `${nT}px`;
                if (window.isSystemOpen) { expandBubblesVisual(); window.positionPopup(window.currentPopupMode); }
            }
        };
        const onDragEnd = () => {
            document.removeEventListener('mousemove', onDragMove); document.removeEventListener('mouseup', onDragEnd);
            document.removeEventListener('touchmove', onDragMove); document.removeEventListener('touchend', onDragEnd);
            document.body.classList.remove('no-select'); wrapper.style.transition = '';
            if (isDragging) { localStorage.setItem(storageKeyPos, JSON.stringify({ left: wrapper.style.left, top: wrapper.style.top })); setTimeout(() => isDragging = false, 50); }
        };

        mainBubble.addEventListener('mousedown', onDragStart);
        mainBubble.addEventListener('touchstart', onDragStart, { passive: false });
        mainBubble.onclick = () => {
            mainBubble.classList.add('hover-glow');
            if(window.NeonManager) window.NeonManager.wakeUp();
            if (!isDragging) window.isSystemOpen ? closeAll() : openAll('menu');
        };

        window.openAll = (mode) => {
            if(window.NeonManager) window.NeonManager.wakeUp();
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
            if(window.NeonManager) window.NeonManager.wakeUp();
            window.isSystemOpen = false; wrapper.classList.remove('expanded'); popup.classList.remove('active');
            icon.classList.replace('fa-xmark', 'fa-bars'); backdrop.classList.remove('active');
            mainBubble.classList.remove('red-mode'); highlight(null);
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

        window.positionPopup = (type) => {
            const r = wrapper.getBoundingClientRect(); const sw = window.innerWidth; const sh = window.innerHeight; const gap = 15;
            popup.style.left = ''; popup.style.right = ''; popup.style.top = ''; popup.style.bottom = '';
            if (sw < 998) {
                popup.style.width = '90vw'; popup.style.left = '50%'; popup.style.transform = 'translateX(-50%)';
                if (r.top > sh / 2) {
                    let availableHeight = r.top - gap - gap; popup.style.maxHeight = availableHeight + 'px'; popup.style.bottom = (sh - r.top + gap) + 'px';
                } else {
                    let availableHeight = sh - r.bottom - gap - gap; popup.style.maxHeight = availableHeight + 'px'; popup.style.top = (r.bottom + gap) + 'px';
                }
            } else {
                if (r.left > sw / 2) popup.style.right = (sw - r.left + gap) + 'px'; else popup.style.left = (r.right + gap) + 'px';
                popup.style.maxHeight = (sh - (gap * 2)) + 'px'; const ph = popup.offsetHeight; let finalTop = r.top;
                if (r.top >= sh / 2) finalTop = r.bottom - ph;
                if (finalTop + ph > sh - gap) finalTop = sh - ph - gap; if (finalTop < gap) finalTop = gap;
                popup.style.top = finalTop + 'px';
            }
        };

        btns.menu?.addEventListener('click', (e) => { e.stopPropagation(); openAll('menu'); });
        btns.chat?.addEventListener('click', (e) => { e.stopPropagation(); openAll('chat'); });
        btns.settings?.addEventListener('click', (e) => { e.stopPropagation(); openAll('settings'); });
    });
</script>
