{{-- HTML BUBBLES --}}
<div id="bubble-wrapper" style="position: fixed; bottom: 30px; right: 30px; z-index: 10000;">
    <div class="sub-bubbles-container">
        <div class="sub-bubble" id="btn-scroll-top" title="Lên đầu trang"><i class="fa-solid fa-arrow-up"></i></div>
        <div class="sub-bubble" id="btn-open-chat" title="Tin nhắn">
            <i class="fa-solid fa-comments"></i>
            <span class="badge-counter">1</span>
        </div>
        <div class="sub-bubble" id="btn-scroll-bottom" title="Xuống cuối trang"><i class="fa-solid fa-arrow-down"></i></div>
    </div>
    <div id="nav-bubble" title="Menu">
        <i class="fa-solid fa-bars" id="bubble-icon"></i>
        <span class="main-bubble-badge"></span>
    </div>
</div>

<style>
    /* CSS CHO CONTAINER POPUP VÀ BUBBLES */
    #nav-backdrop { position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 9998; opacity: 0; visibility: hidden; transition: 0.3s; backdrop-filter: blur(2px); }
    #nav-backdrop.active { opacity: 1; visibility: visible; }

    #bubble-wrapper {
        position: fixed; bottom: 30px; right: 30px; z-index: 10000;
        /* UPDATED: Transition mượt mà cho cả Scale và Transform */
        transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), opacity 0.3s ease;
    }

    /* NEW: Class ẩn bong bóng khi scroll */
    #bubble-wrapper.scroll-hidden {
        transform: scale(0) !important; /* Thu nhỏ về 0 */
        opacity: 0; /* Mờ dần */
        pointer-events: none; /* Không bấm nhầm khi ẩn */
    }

    #nav-bubble { width: 60px; height: 60px; background: linear-gradient(135deg, #0ea5e9, #0284c7); color: #fff; border-radius: 50%; box-shadow: 0 4px 15px rgba(14, 165, 233, 0.4); display: flex; align-items: center; justify-content: center; font-size: 24px; cursor: pointer; position: relative; z-index: 2; }
    #nav-bubble:hover { transform: scale(1.05); } #nav-bubble:active { transform: scale(0.95); }

    .main-bubble-badge { position: absolute; top: 0; right: 0; width: 18px; height: 18px; background-color: #ef4444; border: 2px solid #fff; border-radius: 50%; display: block; box-shadow: 0 2px 5px rgba(0,0,0,0.2); z-index: 10; }
    body.dark-mode .main-bubble-badge { border-color: #0f172a; }

    .sub-bubbles-container { position: absolute; left: 0; width: 60px; display: flex; flex-direction: column; align-items: center; gap: 10px; pointer-events: none; }
    .sub-bubble { width: 45px; height: 45px; background-color: var(--popup-bg); border: 1px solid var(--popup-border); color: var(--text-color); backdrop-filter: blur(10px); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); cursor: pointer; opacity: 0; transform: scale(0); transition: all 0.3s; }
    .sub-bubble:hover { background-color: var(--primary); color: #fff; }
    #bubble-wrapper.expanded .sub-bubble { opacity: 1; transform: scale(1); pointer-events: auto; }
    .badge-counter { position: absolute; top: -5px; right: -5px; background: #ef4444; color: white; font-size: 10px; padding: 2px 6px; border-radius: 10px; font-weight: bold; }

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

        // Khai báo biến global để các file khác gọi được
        window.isSystemOpen = false;
        window.currentPopupMode = 'menu'; // 'menu' or 'chat'

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

            // UPDATED: Sử dụng transition CSS (đã định nghĩa 0.3s) thay vì inline style 0.1s
            wrapper.style.transition = '';

            if (isDragging) { localStorage.setItem('client_bubblePos', JSON.stringify({ left: wrapper.style.left, top: wrapper.style.top })); setTimeout(() => { isDragging = false; }, 50); }
        };
        mainBubble.addEventListener('mousedown', onDragStart); mainBubble.addEventListener('touchstart', onDragStart, { passive: false });
        mainBubble.onclick = (e) => { if (isDragging) return; if (e.cancelable && e.type === 'touchend') e.preventDefault(); if (window.isSystemOpen) closeAll(); else openAll('menu'); };

        // --- 2. HỆ THỐNG ĐIỀU KHIỂN (OPEN/CLOSE/POSITION) ---
        window.openAll = function(mode) {
            window.isSystemOpen = true; window.currentPopupMode = mode;
            expandBubblesVisual();

            // Hiện bong bóng nếu đang ẩn (đảm bảo nó hiện ra khi mở menu)
            wrapper.classList.remove('scroll-hidden');

            // Gọi hàm render nội dung từ các file con
            if(mode === 'menu' && typeof window.renderMenuContent === 'function') window.renderMenuContent();
            if(mode === 'chat' && typeof window.renderChatContent === 'function') window.renderChatContent();

            wrapper.classList.add('expanded'); icon.classList.replace('fa-bars', 'fa-xmark'); backdrop.classList.add('active');
            popup.classList.add('active');

            setTimeout(() => window.positionPopup(mode), 10);
        };

        window.closeAll = function() {
            window.isSystemOpen = false;
            wrapper.classList.remove('expanded'); popup.classList.remove('active');
            icon.classList.replace('fa-xmark', 'fa-bars'); backdrop.classList.remove('active');
        };

        window.expandBubblesVisual = function() {
            const rect = wrapper.getBoundingClientRect(); const screenW = window.innerWidth; const screenH = window.innerHeight; const isMobile = screenW < 998;
            subBubblesContainer.style.cssText = 'position: absolute; width: max-content; height: 60px; display: flex; gap: 10px; pointer-events: none;';
            if (isMobile) {
                subBubblesContainer.style.flexDirection = 'row'; subBubblesContainer.style.top = '0';
                if (rect.left > screenW / 2) { subBubblesContainer.style.right = '100%'; subBubblesContainer.style.justifyContent = 'flex-end'; subBubblesContainer.style.paddingRight = '15px'; }
                else { subBubblesContainer.style.left = '100%'; subBubblesContainer.style.justifyContent = 'flex-start'; subBubblesContainer.style.paddingLeft = '15px'; }
            } else {
                subBubblesContainer.style.width = '60px'; subBubblesContainer.style.height = 'auto'; subBubblesContainer.style.left = '0'; subBubblesContainer.style.flexDirection = 'column';
                if (rect.top > screenH / 2) { subBubblesContainer.style.bottom = '100%'; subBubblesContainer.style.paddingBottom = '15px'; }
                else { subBubblesContainer.style.top = '100%'; subBubblesContainer.style.paddingTop = '15px'; }
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
                let availableWidth = 0;
                if (rect.left > screenW / 2) { popup.style.right = (screenW - rect.left + gap) + 'px'; popup.style.left = 'auto'; availableWidth = rect.left - gap - edgePadding; popup.style.transformOrigin = 'right center'; }
                else { popup.style.left = (rect.right + gap) + 'px'; popup.style.right = 'auto'; availableWidth = screenW - rect.right - gap - edgePadding; popup.style.transformOrigin = 'left center'; }

                const pHeight = popup.scrollHeight; const bubbleCenterY = rect.top + (rect.height / 2); let idealTop = bubbleCenterY - (pHeight / 2);
                const minTop = 20; const maxTop = screenH - pHeight - 20;
                popup.style.top = Math.max(minTop, Math.min(idealTop, maxTop)) + 'px'; popup.style.maxHeight = (screenH - 40) + 'px';
            }
        };

        // --- 3. BẮT SỰ KIỆN NÚT PHỤ ---
        const btnTop = document.getElementById('btn-scroll-top');
        const btnBottom = document.getElementById('btn-scroll-bottom');
        const btnChat = document.getElementById('btn-open-chat');

        if(btnTop) btnTop.addEventListener('click', () => { mainWrapper.scrollTo({ top: 0, behavior: 'smooth' }); closeAll(); });
        if(btnBottom) btnBottom.addEventListener('click', () => { mainWrapper.scrollTo({ top: mainWrapper.scrollHeight, behavior: 'smooth' }); closeAll(); });
        if(btnChat) btnChat.addEventListener('click', () => { openAll('chat'); });
        backdrop.addEventListener('click', closeAll);

        let resizeTimer;
        window.addEventListener('resize', () => { clearTimeout(resizeTimer); resizeTimer = setTimeout(() => { if (window.isSystemOpen) { expandBubblesVisual(); window.positionPopup(window.currentPopupMode); } }, 100); });
    });
</script>
