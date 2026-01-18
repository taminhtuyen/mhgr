<div id="bubble-wrapper" style="position: fixed; bottom: 40px; right: 40px; z-index: 10000;">
    <div class="sub-bubbles-container">
        <div class="sub-bubble" id="btn-scroll-top" title="Lên đầu trang"><i class="fa-solid fa-arrow-up"></i></div>
        <div class="sub-bubble" id="btn-open-chat" title="Tin nhắn">
            <i class="fa-solid fa-comments"></i>
            <span class="badge-counter">3</span>
        </div>
        <div class="sub-bubble" id="btn-scroll-bottom" title="Xuống cuối trang"><i class="fa-solid fa-arrow-down"></i></div>
    </div>
    <div id="nav-bubble" title="Menu">
        <i class="fa-solid fa-bars" id="bubble-icon"></i>
        <span class="main-bubble-badge"></span>
    </div>
</div>

<style>
    /* CSS CONTAINER POPUP & BUBBLES */
    #nav-backdrop { position: fixed; inset: 0; background: rgba(0,0,0,0.3); z-index: 9998; opacity: 0; visibility: hidden; transition: 0.3s; backdrop-filter: blur(2px); }
    #nav-backdrop.active { opacity: 1; visibility: visible; }

    #bubble-wrapper {
        position: fixed; bottom: 40px; right: 40px; z-index: 10000;
        transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), opacity 0.3s ease;
    }

    #bubble-wrapper.scroll-hidden {
        transform: scale(0) !important;
        opacity: 0;
        pointer-events: none;
    }

    #nav-bubble { width: 60px; height: 60px; background: linear-gradient(135deg, #0ea5e9, #0284c7); color: #fff; border-radius: 50%; box-shadow: 0 4px 15px rgba(14, 165, 233, 0.4); display: flex; align-items: center; justify-content: center; font-size: 24px; cursor: pointer; position: relative; z-index: 2; }
    #nav-bubble:hover { transform: scale(1.05); } #nav-bubble:active { transform: scale(0.95); }

    .main-bubble-badge { position: absolute; top: 0; right: 0; width: 18px; height: 18px; background-color: #ef4444; border: 2px solid #fff; border-radius: 50%; display: block; box-shadow: 0 2px 5px rgba(0,0,0,0.2); z-index: 10; }
    body.dark-mode .main-bubble-badge { border-color: #0f172a; }

    .sub-bubbles-container { position: absolute; left: 0; width: 60px; display: flex; flex-direction: column; align-items: center; gap: 10px; pointer-events: none; }
    .sub-bubble { width: 45px; height: 45px; background-color: var(--popup-bg); border: 1px solid var(--popup-border); color: var(--text-color); backdrop-filter: blur(10px); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); cursor: pointer; opacity: 0; transform: scale(0); transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
    .sub-bubble:hover { background-color: var(--primary); color: #fff; border-color: var(--primary); }
    #bubble-wrapper.expanded .sub-bubble { opacity: 1; transform: scale(1); pointer-events: auto; }
    .badge-counter { position: absolute; top: -5px; right: -5px; background: #ef4444; color: white; font-size: 10px; padding: 2px 6px; border-radius: 10px; font-weight: bold; border: 2px solid var(--popup-bg); }

    /* POPUP CONTAINER */
    #nav-popup {
        position: fixed; z-index: 9999;
        background: var(--popup-bg);
        backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
        border: 1px solid var(--popup-border);
        box-shadow: var(--popup-shadow);
        border-radius: 20px;
        opacity: 0; visibility: hidden; transform: scale(0.95);
        transition: opacity 0.2s ease-out, transform 0.2s cubic-bezier(0.165, 0.84, 0.44, 1);
        overflow: hidden; display: flex; flex-direction: column;
        width: fit-content; max-width: 95vw;
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

        // UPDATED: Lấy mainWrapper để xử lý cuộn lên/xuống
        const mainWrapper = document.getElementById('main-wrapper');

        // Global state
        window.isSystemOpen = false;
        window.currentPopupMode = 'menu';

        // --- 1. LOGIC DRAG & DROP ---
        let isDragging = false, startX, startY, initialLeft, initialTop;
        const savedPos = localStorage.getItem('admin_bubblePos');
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
            if (Math.abs(pos.clientX - startX) > 3 || Math.abs(pos.clientY - startY) > 3) {
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
            popup.style.transition = '';
            wrapper.style.transition = '';
            if (isDragging) { localStorage.setItem('admin_bubblePos', JSON.stringify({ left: wrapper.style.left, top: wrapper.style.top })); setTimeout(() => { isDragging = false; }, 50); }
        };
        mainBubble.addEventListener('mousedown', onDragStart); mainBubble.addEventListener('touchstart', onDragStart, { passive: false });
        mainBubble.onclick = (e) => { if (isDragging) return; if (e.cancelable && e.type === 'touchend') e.preventDefault(); if (window.isSystemOpen) closeAll(); else openAll('menu'); };

        // --- 2. HỆ THỐNG ĐIỀU KHIỂN ---
        window.openAll = function(mode) {
            window.isSystemOpen = true; window.currentPopupMode = mode;
            expandBubblesVisual();
            wrapper.classList.remove('scroll-hidden');
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
            if(typeof window.backToChatList === 'function') setTimeout(window.backToChatList, 300);
        };

        window.expandBubblesVisual = function() {
            const rect = wrapper.getBoundingClientRect(); const screenW = window.innerWidth; const screenH = window.innerHeight; const isMobile = screenW < 998;
            subBubblesContainer.style.cssText = 'position: absolute; display: flex; gap: 10px; pointer-events: none;';
            if (isMobile) {
                subBubblesContainer.style.flexDirection = 'row'; subBubblesContainer.style.top = '7.5px'; subBubblesContainer.style.width = 'max-content';
                if (rect.left > screenW / 2) { subBubblesContainer.style.right = '70px'; subBubblesContainer.style.left = 'auto'; subBubblesContainer.style.justifyContent = 'flex-end'; }
                else { subBubblesContainer.style.left = '70px'; subBubblesContainer.style.right = 'auto'; subBubblesContainer.style.justifyContent = 'flex-start'; }
            } else {
                subBubblesContainer.style.width = '60px'; subBubblesContainer.style.left = '0'; subBubblesContainer.style.flexDirection = 'column';
                if (rect.top > screenH / 2) { subBubblesContainer.style.bottom = '70px'; subBubblesContainer.style.top = 'auto'; }
                else { subBubblesContainer.style.top = '70px'; subBubblesContainer.style.bottom = 'auto'; }
            }
        };

        window.positionPopup = function(type) {
            const rect = wrapper.getBoundingClientRect(); const screenW = window.innerWidth; const screenH = window.innerHeight; const gap = 15; const edgePadding = 20;
            popup.style.removeProperty('inset'); popup.style.left = ''; popup.style.right = ''; popup.style.top = ''; popup.style.bottom = '';
            if (screenW < 998) {
                let vwUnit = 92; if (screenW >= 450) vwUnit = 88;
                popup.style.width = `${vwUnit}vw`; popup.style.maxWidth = `${vwUnit}vw`; popup.style.left = '50%'; popup.style.transform = 'translateX(-50%)';
                if (rect.top > screenH / 2) { popup.style.bottom = (screenH - rect.top + gap) + 'px'; popup.style.top = 'auto'; popup.style.maxHeight = (rect.top - gap - edgePadding) + 'px'; popup.style.transformOrigin = 'bottom center'; }
                else { popup.style.top = (rect.bottom + gap) + 'px'; popup.style.bottom = 'auto'; popup.style.maxHeight = (screenH - rect.bottom - gap - edgePadding) + 'px'; popup.style.transformOrigin = 'top center'; }
            } else {
                popup.style.width = type === 'menu' ? 'fit-content' : 'max-content';
                popup.style.maxWidth = '95vw';
                if (rect.left > screenW / 2) { popup.style.right = (screenW - rect.left + gap) + 'px'; popup.style.left = 'auto'; popup.style.transformOrigin = 'right center'; }
                else { popup.style.left = (rect.right + gap) + 'px'; popup.style.right = 'auto'; popup.style.transformOrigin = 'left center'; }
                const pHeight = popup.scrollHeight; const bubbleCenterY = rect.top + (rect.height / 2); let idealTop = bubbleCenterY - (pHeight / 2);
                const minTop = 20; const maxTop = screenH - pHeight - 20;
                popup.style.top = Math.max(minTop, Math.min(idealTop, maxTop)) + 'px'; popup.style.maxHeight = (screenH - 40) + 'px';
            }
        };

        // --- 3. EVENTS (UPDATED: Sử dụng mainWrapper.scrollTo) ---
        const btnTop = document.getElementById('btn-scroll-top');
        const btnBottom = document.getElementById('btn-scroll-bottom');
        const btnChat = document.getElementById('btn-open-chat');

        if(btnTop) btnTop.addEventListener('click', () => {
            // Sửa: Dùng mainWrapper thay vì window
            mainWrapper.scrollTo({ top: 0, behavior: 'smooth' });
            closeAll();
        });

        if(btnBottom) btnBottom.addEventListener('click', () => {
            // Sửa: Dùng mainWrapper.scrollHeight
            mainWrapper.scrollTo({ top: mainWrapper.scrollHeight, behavior: 'smooth' });
            closeAll();
        });

        if(btnChat) btnChat.addEventListener('click', () => { openAll('chat'); });
        backdrop.addEventListener('click', closeAll);

        let resizeTimer;
        window.addEventListener('resize', () => { clearTimeout(resizeTimer); resizeTimer = setTimeout(() => { if (window.isSystemOpen) { expandBubblesVisual(); window.positionPopup(window.currentPopupMode); } }, 100); });
    });
</script>
