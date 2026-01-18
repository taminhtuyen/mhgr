<div id="bubble-wrapper" style="position: fixed; bottom: 30px; right: 30px; z-index: 10000;">
    {{-- 2 BONG BÓNG CON (MENU & CHAT) --}}
    <div class="sub-bubbles-container">
        {{-- 1. Bong bóng Menu --}}
        <div class="sub-bubble" id="btn-open-menu" title="Menu chức năng">
            <i class="fa-solid fa-table-cells"></i>
        </div>
        {{-- 2. Bong bóng Chat --}}
        <div class="sub-bubble" id="btn-open-chat" title="Tin nhắn">
            <i class="fa-solid fa-comments"></i>
            <span class="badge-counter">1</span>
        </div>
    </div>

    {{-- BONG BÓNG CHÍNH --}}
    <div id="nav-bubble" title="Mở rộng">
        {{-- Icon nằm riêng để xoay độc lập --}}
        <i class="fa-solid fa-bars" id="bubble-icon"></i>
        <span class="main-bubble-badge"></span>
    </div>
</div>

<style>
    /* --- DEFINITIONS --- */
    :root {
        --primary-rgb: 14, 165, 233; /* Màu chủ đạo client */
    }

    /* CSS CONTAINER */
    #nav-backdrop { position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 9998; opacity: 0; visibility: hidden; transition: 0.3s; backdrop-filter: blur(2px); }
    #nav-backdrop.active { opacity: 1; visibility: visible; }

    #bubble-wrapper {
        position: fixed; bottom: 30px; right: 30px; z-index: 10000;
        transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), opacity 0.3s ease;
    }

    #bubble-wrapper.scroll-hidden {
        transform: scale(0) !important;
        opacity: 0;
        pointer-events: none;
    }

    /* MAIN BUBBLE */
    #nav-bubble {
        width: 60px; height: 60px;
        background: linear-gradient(135deg, #0ea5e9, #0284c7);
        color: #fff; border-radius: 50%;
        box-shadow: 0 10px 25px -5px rgba(14, 165, 233, 0.5);
        display: flex; align-items: center; justify-content: center;
        font-size: 24px; cursor: pointer; position: relative; z-index: 2;
        transition: all 0.3s ease;
    }
    #nav-bubble:hover { transform: translateY(-3px); box-shadow: 0 15px 30px -5px rgba(14, 165, 233, 0.6); }
    #nav-bubble:active { transform: scale(0.95); }

    /* TRẠNG THÁI RED MODE (KHI MỞ) */
    #nav-bubble.red-mode {
        background: linear-gradient(135deg, #ef4444, #dc2626) !important;
        box-shadow: 0 10px 25px -5px rgba(239, 68, 68, 0.5);
        transform: scale(1);
    }

    /* ICON BÊN TRONG (SẼ XOAY) */
    #bubble-icon {
        transition: transform 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55);
    }
    #nav-bubble.red-mode #bubble-icon {
        transform: rotate(180deg);
    }

    /* DẤU CHẤM ĐỎ (BADGE) */
    .main-bubble-badge {
        position: absolute; top: 0; right: 0;
        width: 18px; height: 18px;
        background-color: #ef4444;
        border: 2px solid #fff; border-radius: 50%;
        display: block;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        z-index: 10;
    }
    body.dark-mode .main-bubble-badge { border-color: #0f172a; }

    /* SUB BUBBLES CONTAINER */
    .sub-bubbles-container { position: absolute; left: 0; width: 60px; display: flex; flex-direction: column; align-items: center; gap: 20px; pointer-events: none; }

    /* SUB BUBBLES STYLE - NORMAL STATE */
    .sub-bubble {
        width: 50px; height: 50px;
        background-color: var(--popup-bg);
        border: 1px solid var(--popup-border);
        color: var(--text-color);
        backdrop-filter: blur(10px); border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 20px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        cursor: pointer; opacity: 0; transform: scale(0);
        /* Transition mượt mà cho hiệu ứng toả sáng */
        transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        position: relative;
    }
    .sub-bubble:hover {
        background-color: #fff;
        color: var(--primary);
        transform: translateY(-2px);
    }

    /* ACTIVE STATE (ĐƯỢC CHỌN - TĨNH, KHÔNG NHẤP NHÁY) */
    .sub-bubble.active {
        /* 1. Nền Gradient */
        background: linear-gradient(135deg, #0ea5e9, #2563eb) !important;
        /* 2. Màu chữ trắng */
        color: #fff !important;
        /* 3. Viền phát sáng nhẹ */
        border: 1px solid rgba(255,255,255,0.4) !important;
        /* 4. Scale to hơn chút */
        transform: scale(1.15) !important;
        /* 5. BOX-SHADOW TĨNH (STATIC GLOW) */
        box-shadow:
            0 0 0 4px rgba(14, 165, 233, 0.2),  /* Vầng sáng mờ bao quanh (Ring) */
            0 10px 25px -5px rgba(14, 165, 233, 0.7), /* Bóng đổ sâu bên dưới */
            0 0 20px rgba(14, 165, 233, 0.5) !important; /* Ánh sáng toả ra xung quanh */
    }

    #bubble-wrapper.expanded .sub-bubble { opacity: 1; transform: scale(1); pointer-events: auto; }

    .badge-counter { position: absolute; top: -5px; right: -5px; background: #ef4444; color: white; font-size: 10px; padding: 2px 6px; border-radius: 10px; font-weight: bold; border: 2px solid #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.2); }

    /* POPUP CONTAINER STYLE */
    #nav-popup {
        position: fixed; z-index: 9999;
        background: var(--popup-bg);
        backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
        border: 1px solid var(--popup-border);
        box-shadow: var(--popup-shadow);
        border-radius: 16px;
        opacity: 0; visibility: hidden; transform: scale(0.95);
        transition: opacity 0.2s, transform 0.2s;
        width: fit-content; max-width: 95vw;
        overflow: hidden; display: flex; flex-direction: column; overscroll-behavior: contain;
    }
    #nav-popup.active { opacity: 1; visibility: visible; transform: scale(1); }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const wrapper = document.getElementById('bubble-wrapper');
        const mainBubble = document.getElementById('nav-bubble');
        const subBubblesContainer = wrapper.querySelector('.sub-bubbles-container');
        const popup = document.getElementById('nav-popup');
        const backdrop = document.getElementById('nav-backdrop');
        const icon = document.getElementById('bubble-icon');
        const mainWrapper = document.getElementById('main-wrapper');

        // Buttons
        const btnMenu = document.getElementById('btn-open-menu');
        const btnChat = document.getElementById('btn-open-chat');

        // Global state
        window.isSystemOpen = false;
        window.currentPopupMode = 'menu'; // Default

        // --- 1. LOGIC DRAG & DROP ---
        let isDragging = false, startX, startY, initialLeft, initialTop;
        const savedPos = localStorage.getItem('client_bubblePos');
        if (savedPos) { const pos = JSON.parse(savedPos); wrapper.style.left = pos.left; wrapper.style.top = pos.top; wrapper.style.bottom = 'auto'; wrapper.style.right = 'auto'; }

        const getClientPos = (e) => e.touches ? e.touches[0] : e;
        const onDragStart = (e) => {
            isDragging = false; const pos = getClientPos(e); startX = pos.clientX; startY = pos.clientY;
            const rect = wrapper.getBoundingClientRect(); initialLeft = rect.left; initialTop = rect.top;
            wrapper.style.left = rect.left + 'px'; wrapper.style.top = rect.top + 'px'; wrapper.style.bottom = 'auto'; wrapper.style.right = 'auto';
            wrapper.style.transition = 'none'; document.body.classList.add('no-select');
            if(window.isSystemOpen) popup.style.transition = 'none';
            document.addEventListener('mousemove', onDragMove); document.addEventListener('mouseup', onDragEnd);
            document.addEventListener('touchmove', onDragMove, { passive: false }); document.addEventListener('touchend', onDragEnd);
        };
        const onDragMove = (e) => {
            const pos = getClientPos(e);
            if (Math.abs(pos.clientX - startX) > 5 || Math.abs(pos.clientY - startY) > 5) {
                isDragging = true; if(e.cancelable) e.preventDefault();
                let newLeft = initialLeft + (pos.clientX - startX); let newTop = initialTop + (pos.clientY - startY);
                newLeft = Math.min(Math.max(0, newLeft), window.innerWidth - wrapper.offsetWidth);
                newTop = Math.min(Math.max(0, newTop), window.innerHeight - wrapper.offsetHeight);
                wrapper.style.left = `${newLeft}px`; wrapper.style.top = `${newTop}px`;
                if (window.isSystemOpen) { expandBubblesVisual(); window.positionPopup(window.currentPopupMode); }
            }
        };
        const onDragEnd = () => {
            document.removeEventListener('mousemove', onDragMove); document.removeEventListener('mouseup', onDragEnd);
            document.removeEventListener('touchmove', onDragMove); document.removeEventListener('touchend', onDragEnd);
            document.body.classList.remove('no-select');
            popup.style.transition = 'opacity 0.2s, transform 0.2s';
            wrapper.style.transition = '';
            if (isDragging) { localStorage.setItem('client_bubblePos', JSON.stringify({ left: wrapper.style.left, top: wrapper.style.top })); setTimeout(() => { isDragging = false; }, 50); }
        };
        mainBubble.addEventListener('mousedown', onDragStart); mainBubble.addEventListener('touchstart', onDragStart, { passive: false });

        // --- CLICK MAIN BUBBLE ---
        mainBubble.onclick = (e) => {
            if (isDragging) return;
            if (e.cancelable && e.type === 'touchend') e.preventDefault();

            if (window.isSystemOpen) {
                closeAll();
            } else {
                openAll('menu'); // Mặc định mở Menu
            }
        };

        // --- 2. HỆ THỐNG ĐIỀU KHIỂN (OPEN/CLOSE/POSITION) ---
        window.openAll = function(mode) {
            window.isSystemOpen = true; window.currentPopupMode = mode;
            expandBubblesVisual();

            wrapper.classList.remove('scroll-hidden');

            // Render Content
            if(mode === 'menu' && typeof window.renderMenuContent === 'function') window.renderMenuContent();
            if(mode === 'chat' && typeof window.renderChatContent === 'function') window.renderChatContent();

            wrapper.classList.add('expanded');
            icon.classList.replace('fa-bars', 'fa-xmark');
            backdrop.classList.add('active');
            popup.classList.add('active');

            // Hiệu ứng: Chuyển màu đỏ & Sáng bong bóng con
            mainBubble.classList.add('red-mode');
            highlightActiveBubble(mode);

            setTimeout(() => window.positionPopup(mode), 10);
        };

        window.closeAll = function() {
            window.isSystemOpen = false;
            wrapper.classList.remove('expanded'); popup.classList.remove('active');
            icon.classList.replace('fa-xmark', 'fa-bars'); backdrop.classList.remove('active');

            // Tắt hiệu ứng
            mainBubble.classList.remove('red-mode');
            if(btnMenu) btnMenu.classList.remove('active');
            if(btnChat) btnChat.classList.remove('active');
        };

        function highlightActiveBubble(mode) {
            if(btnMenu) btnMenu.classList.remove('active');
            if(btnChat) btnChat.classList.remove('active');
            if (mode === 'menu' && btnMenu) btnMenu.classList.add('active');
            if (mode === 'chat' && btnChat) btnChat.classList.add('active');
        }

        window.expandBubblesVisual = function() {
            const rect = wrapper.getBoundingClientRect(); const screenW = window.innerWidth; const screenH = window.innerHeight; const isMobile = screenW < 998;
            subBubblesContainer.style.cssText = 'position: absolute; display: flex; gap: 20px; pointer-events: none;';
            if (isMobile) {
                subBubblesContainer.style.flexDirection = 'row'; subBubblesContainer.style.top = '5px'; subBubblesContainer.style.width = 'max-content';
                if (rect.left > screenW / 2) { subBubblesContainer.style.right = '70px'; subBubblesContainer.style.left = 'auto'; subBubblesContainer.style.justifyContent = 'flex-end'; }
                else { subBubblesContainer.style.left = '70px'; subBubblesContainer.style.right = 'auto'; subBubblesContainer.style.justifyContent = 'flex-start'; }
            } else {
                subBubblesContainer.style.width = '60px'; subBubblesContainer.style.left = '0'; subBubblesContainer.style.flexDirection = 'column';
                if (rect.top > screenH / 2) { subBubblesContainer.style.bottom = '70px'; subBubblesContainer.style.top = 'auto'; }
                else { subBubblesContainer.style.top = '70px'; subBubblesContainer.style.bottom = 'auto'; }
            }
        };

        window.positionPopup = function(type) {
            const rect = wrapper.getBoundingClientRect(); const screenW = window.innerWidth; const screenH = window.innerHeight; const gap = 20; const edgePadding = 20;
            popup.style.removeProperty('inset'); popup.style.left = ''; popup.style.right = ''; popup.style.top = ''; popup.style.bottom = '';

            if (screenW < 998) { // Mobile
                let vwUnit = 88; if (screenW < 400) vwUnit = 92;
                popup.style.width = `${vwUnit}vw`; popup.style.maxWidth = `${vwUnit}vw`; popup.style.left = '50%'; popup.style.transform = 'translateX(-50%)';
                if (rect.top > screenH / 2) { popup.style.bottom = (screenH - rect.top + gap) + 'px'; popup.style.top = 'auto'; popup.style.maxHeight = (rect.top - gap - edgePadding) + 'px'; popup.style.transformOrigin = 'bottom center'; }
                else { popup.style.top = (rect.bottom + gap) + 'px'; popup.style.bottom = 'auto'; popup.style.maxHeight = (screenH - rect.bottom - gap - edgePadding) + 'px'; popup.style.transformOrigin = 'top center'; }
            } else { // PC
                popup.style.width = type === 'menu' ? 'fit-content' : 'max-content';
                popup.style.maxWidth = '95vw';
                if (rect.left > screenW / 2) { popup.style.right = (screenW - rect.left + gap) + 'px'; popup.style.left = 'auto'; popup.style.transformOrigin = 'right center'; }
                else { popup.style.left = (rect.right + gap) + 'px'; popup.style.right = 'auto'; popup.style.transformOrigin = 'left center'; }

                const pHeight = popup.scrollHeight; const bubbleCenterY = rect.top + (rect.height / 2); let idealTop = bubbleCenterY - (pHeight / 2);
                const minTop = 20; const maxTop = screenH - pHeight - 20;
                popup.style.top = Math.max(minTop, Math.min(idealTop, maxTop)) + 'px'; popup.style.maxHeight = (screenH - 40) + 'px';
            }
        };

        // --- 3. BẮT SỰ KIỆN SUB-BUBBLES ---
        // Sửa: Thêm sự kiện cho nút Menu và Chat
        if(btnMenu) btnMenu.addEventListener('click', (e) => { e.stopPropagation(); openAll('menu'); });
        if(btnChat) btnChat.addEventListener('click', (e) => { e.stopPropagation(); openAll('chat'); });

        // QUAN TRỌNG: Đã xóa sự kiện backdrop click để đóng popup
        // backdrop.addEventListener('click', closeAll); -> DELETED

        let resizeTimer;
        window.addEventListener('resize', () => { clearTimeout(resizeTimer); resizeTimer = setTimeout(() => { if (window.isSystemOpen) { expandBubblesVisual(); window.positionPopup(window.currentPopupMode); } }, 100); });
    });
</script>
