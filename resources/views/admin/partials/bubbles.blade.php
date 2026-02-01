<div id="bubble-wrapper" style="position: fixed; bottom: 2.5rem; right: 2.5rem; z-index: 10000;">
    {{-- 3 BONG BÓNG CON --}}
    <div class="sub-bubbles-container">
        <div class="sub-bubble neon-target" id="btn-open-menu" title="Menu chức năng">
            <i class="fa-solid fa-table-cells"></i>
        </div>
        <div class="sub-bubble neon-target" id="btn-open-chat" title="Tin nhắn">
            <i class="fa-solid fa-comments"></i>
            <span class="badge-counter">3</span>
        </div>
        <div class="sub-bubble neon-target" id="btn-open-settings" title="Cài đặt">
            <i class="fa-solid fa-gear"></i>
        </div>
    </div>

    {{-- BONG BÓNG CHÍNH --}}
    <div id="nav-bubble" class="neon-target" title="Mở rộng">
        <i class="fa-solid fa-bars" id="bubble-icon"></i>
        <span class="main-bubble-badge"></span>
    </div>
</div>

<style>
    /* --- BIẾN MÀU --- */
    :root {
        --neon-primary: 0, 191, 255; /* Xanh da trời */
        --neon-danger: 255, 49, 49;  /* Đỏ */
        --sub-bg: #ffffff;
        --sub-border: #d1d5db;
        --sub-text: #374151;
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
        opacity: 1; visibility: visible; transform: scale(1); will-change: transform;
    }
    #bubble-wrapper.scroll-hidden { transform: scale(0.9); opacity: 0; visibility: hidden; pointer-events: none; }

    /* =================================================================
       1. TRẠNG THÁI OFF (TẮT DẦN 2 GIÂY)
       Kỹ thuật: Khai báo sẵn các lớp shadow trong suốt để browser tính toán được transition
       ================================================================= */

    #nav-bubble, .sub-bubble {
        /* Transition mặc định (khi tắt) là 2s */
        transition:
            transform 0.3s ease,
            background-color 0.3s ease,
            opacity 0.3s ease,
            box-shadow 2s ease-out,  /* Tắt chậm 2s */
            border-color 2s ease-out; /* Tắt chậm 2s */

        /* Bắt buộc: Khai báo shadow rỗng nhưng đúng cấu trúc (5 lớp) để không bị giật */
        box-shadow:
            0 0 0 0 rgba(0,0,0,0) inset,
            0 0 0 0 rgba(0,0,0,0) inset,
            0 0 0 0 rgba(0,0,0,0),
            0 0 0 0 rgba(0,0,0,0),
            0 0 0 0 rgba(0,0,0,0);

        border-color: transparent;
        will-change: box-shadow, border-color; /* Tối ưu GPU */
    }

    /* Cấu hình riêng cho bong bóng chính */
    #nav-bubble {
        width: 3.75rem; height: 3.75rem;
        background: linear-gradient(135deg, #0ea5e9, #0284c7);
        color: #fff; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; cursor: pointer; position: relative; z-index: 10;
        border: 0.0625rem solid transparent;
        transform: scale(1);
    }

    /* Cấu hình riêng cho bong bóng con */
    .sub-bubble {
        width: 3.125rem; height: 3.125rem;
        background-color: var(--sub-bg); border: 0.0625rem solid var(--sub-border); color: var(--sub-text);
        backdrop-filter: blur(0.6rem); border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.25rem; cursor: pointer; opacity: 0; transform: scale(0); position: relative;
    }

    /* Icon bên trong */
    #bubble-icon, .sub-bubble i {
        filter: drop-shadow(0 0 0 rgba(0,0,0,0)); /* Shadow rỗng */
        transition: filter 2s ease-out, transform 0.4s ease; /* Tắt chậm 2s */
    }

    /* =================================================================
       2. TRẠNG THÁI ON (BẬT NHANH 0.5 GIÂY)
       Khi body có class .neon-active, các giá trị này sẽ đè lên
       ================================================================= */

    body.neon-active #nav-bubble,
    body.neon-active .sub-bubble.active {
        border-color: #fff;

        /* Shadow phát sáng (5 lớp tương ứng với 5 lớp rỗng ở trên) */
        box-shadow:
            0 0 0.1rem rgb(var(--neon-primary)) inset,
            0 0 0.5rem rgb(var(--neon-primary)) inset,
            0 0 1rem rgb(var(--neon-primary)),
            0 0 2.5rem rgb(var(--neon-primary)),
            0 0.5rem 1rem rgba(0, 0, 0, 0.2);

        /* Ghi đè thời gian transition thành 0.5s để bật nhanh */
        transition:
            transform 0.3s ease,
            background-color 0.3s ease,
            opacity 0.3s ease,
            box-shadow 0.5s ease-out, /* Bật nhanh 0.5s */
            border-color 0.5s ease-out;
    }

    /* Màu đỏ khi mở menu */
    body.neon-active #nav-bubble.red-mode {
        box-shadow:
            0 0 0.1rem rgb(var(--neon-danger)) inset,
            0 0 0.5rem rgb(var(--neon-danger)) inset,
            0 0 1.5rem rgb(var(--neon-danger)),
            0 0 3.5rem rgb(var(--neon-danger)),
            0 0.5rem 1rem rgba(0, 0, 0, 0.2);
    }

    /* Icon phát sáng */
    body.neon-active #nav-bubble:hover #bubble-icon,
    body.neon-active .sub-bubble.active i {
        filter: drop-shadow(0 0 0.3rem rgb(var(--neon-primary)));
        transition: filter 0.5s ease-out; /* Bật nhanh 0.5s */
    }

    body.neon-active #nav-bubble.red-mode #bubble-icon {
        filter: drop-shadow(0 0 0.5rem rgb(var(--neon-danger)));
    }

    /* =================================================================
       3. CÁC TRẠNG THÁI KHÁC
       ================================================================= */

    /* Active vật lý (khi mở menu) */
    .sub-bubble.active {
        background: linear-gradient(135deg, #0ea5e9, #0284c7) !important;
        border: 0.0625rem solid #fff !important;
        color: #fff !important;
        transform: scale(1.15) !important;
        opacity: 1 !important;
    }

    #nav-bubble.red-mode {
        background: linear-gradient(135deg, #ef4444, #dc2626) !important;
        border-color: #fff !important;
    }
    #nav-bubble.red-mode #bubble-icon { transform: rotate(90deg); }

    /* Hover nhẹ khi chưa active */
    #bubble-wrapper.expanded .sub-bubble:not(.active):hover {
        transform: scale(1.1);
        transition: transform 0.2s;
    }

    /* Layout utils */
    .sub-bubbles-container { position: absolute; left: 0; width: 3.75rem; display: flex; flex-direction: column; align-items: center; gap: 1rem; pointer-events: none; z-index: 1; }
    .main-bubble-badge { position: absolute; top: 0; right: 0; width: 1rem; height: 1rem; background-color: #ef4444; border: 0.0625rem solid #fff; border-radius: 50%; z-index: 11; box-shadow: 0 2px 4px rgba(0,0,0,0.2); pointer-events: none; transition: box-shadow 2s ease-out; }
    body.neon-active .main-bubble-badge { box-shadow: 0 0 5px #ef4444; transition: box-shadow 0.5s ease-out; }

    /* Popup & Backdrop */
    #nav-popup { position: fixed; z-index: 9999; background: var(--popup-bg); backdrop-filter: blur(1rem); border: 0.0625rem solid var(--popup-border); box-shadow: var(--popup-shadow); border-radius: 1.25rem !important; overflow: hidden !important; overflow-y: auto !important; -webkit-overflow-scrolling: touch; opacity: 0; visibility: hidden; transform: scale(0.95); transition: opacity 0.2s, transform 0.2s; width: fit-content; max-width: 95vw; display: flex; flex-direction: column; scrollbar-width: thin; }
    #nav-popup.active { opacity: 1; visibility: visible; transform: scale(1); }
    #nav-backdrop { position: fixed; inset: 0; background: rgba(0,0,0,0.3); z-index: 9998; opacity: 0; visibility: hidden; transition: 0.3s; backdrop-filter: blur(2px); }
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

        // --- GÁN SỰ KIỆN NEON (Hover In / Hover Out) ---
        const neonTargets = document.querySelectorAll('.neon-target');
        neonTargets.forEach(el => {
            el.addEventListener('mouseenter', () => { if(window.NeonManager) window.NeonManager.wakeUp(); });
            el.addEventListener('mouseleave', () => { if(window.NeonManager) window.NeonManager.sleep(); });
            el.addEventListener('click', () => { if(window.NeonManager) window.NeonManager.wakeUp(); });
        });

        // --- DRAG LOGIC ---
        let isDragging = false, startX, startY, initialLeft, initialTop;
        const storageKeyPos = 'admin_bubblePos';
        const restorePosition = () => {
            const savedPos = localStorage.getItem(storageKeyPos);
            if (savedPos) {
                try {
                    const pos = JSON.parse(savedPos);
                    let left = Math.min(Math.max(0, pos.left), window.innerWidth - 60);
                    let top = Math.min(Math.max(0, pos.top), window.innerHeight - 60);
                    wrapper.style.left = left + 'px'; wrapper.style.top = top + 'px';
                    wrapper.style.bottom = 'auto'; wrapper.style.right = 'auto';
                } catch (e) {}
            }
        };
        restorePosition();

        window.addEventListener('resize', () => { if(window.isSystemOpen) window.positionPopup(window.currentPopupMode); });

        const getPos = (e) => e.touches ? e.touches[0] : e;
        const onDragStart = (e) => {
            if(window.NeonManager) window.NeonManager.wakeUp();
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
            if (isDragging) { localStorage.setItem(storageKeyPos, JSON.stringify({ left: parseFloat(wrapper.style.left), top: parseFloat(wrapper.style.top) })); setTimeout(() => isDragging = false, 50); }
        };

        mainBubble.addEventListener('mousedown', onDragStart);
        mainBubble.addEventListener('touchstart', onDragStart, { passive: false });
        mainBubble.onclick = () => { if (!isDragging) window.isSystemOpen ? closeAll() : openAll('menu'); };

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
