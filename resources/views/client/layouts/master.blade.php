<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cửa Hàng Trực Tuyến')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    {{-- Livewire Styles --}}
    @livewireStyles

    <style>
        /* --- 1. BIẾN MÀU (CLIENT THEME) --- */
        :root {
            --bg-body: #ffffff;
            --text-color: #1e293b;
            --text-muted: #64748b;
            --popup-bg: rgba(255, 255, 255, 0.95);
            --popup-border: rgba(0, 0, 0, 0.08);
            --popup-shadow: 0 20px 50px rgba(0,0,0,0.12);
            --link-hover-bg: #f0f9ff;
            --link-hover-text: #0ea5e9;
            --primary: #0ea5e9;
        }
        body.dark-mode {
            --bg-body: #0f172a;
            --text-color: #f1f5f9;
            --text-muted: #94a3b8;
            --popup-bg: rgba(15, 23, 42, 0.95);
            --popup-border: rgba(255, 255, 255, 0.1);
            --popup-shadow: 0 20px 50px rgba(0,0,0,0.5);
            --link-hover-bg: rgba(255, 255, 255, 0.05);
            --link-hover-text: #38bdf8;
            --primary: #38bdf8;
        }

        body { background-color: var(--bg-body); color: var(--text-color); font-family: 'Segoe UI', sans-serif; overflow-x: hidden; transition: 0.3s; }
        body.no-select { user-select: none; -webkit-user-select: none; }

        #main-wrapper { width: 100%; min-height: 100vh; padding-bottom: 100px; }

        /* --- 2. BACKDROP --- */
        #nav-backdrop { position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 9998; opacity: 0; visibility: hidden; transition: 0.3s; backdrop-filter: blur(2px); }
        #nav-backdrop.active { opacity: 1; visibility: visible; }

        /* --- 3. BONG BÓNG --- */
        #bubble-wrapper { position: fixed; bottom: 30px; right: 30px; z-index: 10000; }

        #nav-bubble {
            width: 60px; height: 60px;
            background: linear-gradient(135deg, #0ea5e9, #0284c7);
            color: #fff; border-radius: 50%;
            box-shadow: 0 4px 15px rgba(14, 165, 233, 0.4);
            display: flex; align-items: center; justify-content: center;
            font-size: 24px; cursor: pointer;
            transition: transform 0.2s;
            position: relative; z-index: 2;
        }
        #nav-bubble:hover { transform: scale(1.05); }
        #nav-bubble:active { transform: scale(0.95); }

        .sub-bubbles-container {
            position: absolute;
            /* Mặc định Desktop: Đổ dọc */
            left: 0; width: 60px;
            display: flex; flex-direction: column; align-items: center; gap: 10px;
            pointer-events: none;
        }

        .sub-bubble { width: 45px; height: 45px; background-color: var(--popup-bg); border: 1px solid var(--popup-border); color: var(--text-color); backdrop-filter: blur(10px); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); cursor: pointer; opacity: 0; transform: scale(0); transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        .sub-bubble:hover { background-color: var(--primary); color: #fff; }
        #bubble-wrapper.expanded .sub-bubble { opacity: 1; transform: scale(1); pointer-events: auto; }
        .badge-counter { position: absolute; top: -5px; right: -5px; background: #ef4444; color: white; font-size: 10px; padding: 2px 6px; border-radius: 10px; font-weight: bold; }

        /* --- 4. POPUP CONTAINER --- */
        #nav-popup {
            position: fixed; z-index: 9999;
            background: var(--popup-bg);
            backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--popup-border);
            box-shadow: var(--popup-shadow);
            border-radius: 16px;
            opacity: 0; visibility: hidden; transform: scale(0.95);
            transition: opacity 0.2s, transform 0.2s;
            width: max-content; max-width: 95vw;
            overflow: hidden;
        }
        #nav-popup.active { opacity: 1; visibility: visible; transform: scale(1); }

        /* --- MENU GRID --- */
        #menu-interface .popup-grid { display: grid; padding: 25px; gap: 25px; }
        .grid-cols-1 { grid-template-columns: 1fr; } .grid-cols-2 { grid-template-columns: repeat(2, 1fr); }
        .grid-cols-3 { grid-template-columns: repeat(3, 1fr); } .grid-cols-4 { grid-template-columns: repeat(4, 1fr); }
        .menu-column { display: flex; flex-direction: column; }
        .group-title { font-size: 0.8rem; font-weight: 800; text-transform: uppercase; color: var(--text-muted); margin-bottom: 12px; border-bottom: 2px solid rgba(148,163,184,0.2); }
        .menu-link { display: flex; align-items: center; padding: 8px 10px; color: var(--text-color); text-decoration: none; border-radius: 8px; font-weight: 500; transition: 0.2s; white-space: nowrap; margin-bottom: 2px; }
        .menu-link:hover { background-color: var(--link-hover-bg); color: var(--link-hover-text); transform: translateX(3px); }
        .menu-link i { width: 24px; color: var(--text-muted); margin-right: 5px; text-align: center; }
        .menu-link:hover i { color: var(--link-hover-text); }
        .popup-header { padding: 15px 25px 0 25px; border-bottom: 1px solid var(--popup-border); }

        /* --- CHAT CSS --- */
        #chat-interface {
            max-width: 800px; width: 800px; /* Desktop Default */
            height: 500px; max-height: 80vh;
            display: flex; flex-direction: column;
        }
        .chat-layout { position: relative; width: 100%; height: 100%; }
        .chat-sidebar { width: 300px; background: rgba(0,0,0,0.02); height: 100%; }
        .chat-window { background: transparent; height: 100%; }
        .chat-item:hover, .chat-item.active { background-color: var(--link-hover-bg); }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

        @media (max-width: 991.98px) {
            #chat-interface { width: 95vw !important; height: 70vh !important; max-width: none !important; }
            /* Logic trượt ngang (Carousel) cho Mobile/Tablet */
            .chat-sidebar {
                width: 100%; height: 100%;
                position: absolute; inset: 0; z-index: 2;
                background: var(--popup-bg);
                transition: transform 0.3s ease-in-out;
                transform: translateX(0);
            }
            .chat-window {
                width: 100%; height: 100%;
                position: absolute; inset: 0; z-index: 2;
                background: var(--popup-bg);
                transition: transform 0.3s ease-in-out;
                transform: translateX(100%);
            }
            #chat-interface.in-conversation .chat-sidebar { transform: translateX(-100%); }
            #chat-interface.in-conversation .chat-window { transform: translateX(0); }
        }

        body.dark-mode .text-dark { color: #f1f5f9 !important; }
        body.dark-mode .text-primary { color: #38bdf8 !important; }

        .theme { display: flex; align-items: center; } .theme__toggle { width: 4em; height: 2em; -webkit-appearance: none; background: #cbd5e1; border-radius: 2em; position: relative; cursor: pointer; transition: 0.3s; } .theme__toggle::after { content: ''; position: absolute; left: 0.2em; top: 0.2em; width: 1.6em; height: 1.6em; background: #fff; border-radius: 50%; transition: 0.3s; } .theme__toggle:checked { background: #0f172a; } .theme__toggle:checked::after { left: 2.2em; }
        .theme-switch-wrapper { transform: scale(0.8); }
    </style>
</head>
<body>

<div id="nav-backdrop"></div>

<div id="main-wrapper">
    {{ $slot ?? '' }}
    @yield('content')
</div>

@include('client.partials.bubbles')

<div id="nav-popup">
    <div id="menu-interface">
        @include('client.partials.menu-popup')
    </div>
    @include('client.partials.chat-popup')
</div>

@livewireScripts

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // --- 1. SETTING THEME ---
        const themeToggle = document.querySelector('#theme');
        const body = document.body;
        if(localStorage.getItem('client_theme_preference') === 'dark') {
            body.classList.add('dark-mode');
            if(themeToggle) themeToggle.checked = true;
        }
        if(themeToggle) themeToggle.addEventListener('change', (e) => {
            body.classList.toggle('dark-mode', e.target.checked);
            localStorage.setItem('client_theme_preference', e.target.checked ? 'dark' : 'light');
        });

        // --- 2. LOGIC BONG BÓNG & MENU ---
        const wrapper = document.getElementById('bubble-wrapper');
        const mainBubble = document.getElementById('nav-bubble');
        const subBubblesContainer = wrapper.querySelector('.sub-bubbles-container');
        const popup = document.getElementById('nav-popup');
        const backdrop = document.getElementById('nav-backdrop');
        const icon = document.getElementById('bubble-icon');
        const menuInterface = document.getElementById('menu-interface');
        const chatInterface = document.getElementById('chat-interface');

        let isDragging = false;
        let startX, startY, initialLeft, initialTop;
        let isSystemOpen = false;
        let currentMode = 'menu';

        // Load Position
        const savedPos = localStorage.getItem('client_bubblePos');
        if (savedPos) {
            const pos = JSON.parse(savedPos);
            wrapper.style.left = pos.left;
            wrapper.style.top = pos.top;
            wrapper.style.bottom = 'auto'; wrapper.style.right = 'auto';
        }

        const getClientPos = (e) => e.touches ? e.touches[0] : e;

        const onDragStart = (e) => {
            isDragging = false;
            const pos = getClientPos(e);
            startX = pos.clientX; startY = pos.clientY;
            const rect = wrapper.getBoundingClientRect();
            initialLeft = rect.left; initialTop = rect.top;

            wrapper.style.bottom = 'auto'; wrapper.style.right = 'auto';
            document.body.classList.add('no-select');

            if(isSystemOpen) popup.style.transition = 'none';

            document.addEventListener('mousemove', onDragMove);
            document.addEventListener('mouseup', onDragEnd);
            document.addEventListener('touchmove', onDragMove, { passive: false });
            document.addEventListener('touchend', onDragEnd);
        };

        const onDragMove = (e) => {
            const pos = getClientPos(e);
            if (Math.abs(pos.clientX - startX) > 5 || Math.abs(pos.clientY - startY) > 5) {
                isDragging = true;
                if(e.cancelable) e.preventDefault();

                wrapper.style.left = `${initialLeft + (pos.clientX - startX)}px`;
                wrapper.style.top = `${initialTop + (pos.clientY - startY)}px`;
                wrapper.style.bottom = 'auto'; wrapper.style.right = 'auto';

                if (isSystemOpen) {
                    expandBubblesVisual();
                    positionPopup(currentMode);
                }
            }
        };

        const onDragEnd = () => {
            document.removeEventListener('mousemove', onDragMove); document.removeEventListener('mouseup', onDragEnd);
            document.removeEventListener('touchmove', onDragMove); document.removeEventListener('touchend', onDragEnd);

            document.body.classList.remove('no-select');
            popup.style.transition = 'opacity 0.2s, transform 0.2s';

            if (isDragging) {
                localStorage.setItem('client_bubblePos', JSON.stringify({ left: wrapper.style.left, top: wrapper.style.top }));
            }
        };

        mainBubble.addEventListener('mousedown', onDragStart);
        mainBubble.addEventListener('touchstart', onDragStart, { passive: false });

        mainBubble.onclick = (e) => {
            if (isDragging) return;
            if (e.cancelable && e.type === 'touchend') e.preventDefault();
            if (isSystemOpen) closeAll(); else openAll('menu');
        };

        function openAll(mode) {
            isSystemOpen = true;
            currentMode = mode;
            expandBubblesVisual();
            openPopupContent(mode);
            wrapper.classList.add('expanded');
            icon.classList.replace('fa-bars', 'fa-xmark');
            backdrop.classList.add('active');
        }

        function closeAll() {
            isSystemOpen = false;
            wrapper.classList.remove('expanded');
            popup.classList.remove('active');
            icon.classList.replace('fa-xmark', 'fa-bars');
            backdrop.classList.remove('active');
        }

        function expandBubblesVisual() {
            const rect = wrapper.getBoundingClientRect();
            const screenW = window.innerWidth;
            const screenH = window.innerHeight;
            const isMobile = screenW < 992; // Tablet/Mobile

            // Reset
            subBubblesContainer.style.top = ''; subBubblesContainer.style.bottom = '';
            subBubblesContainer.style.left = ''; subBubblesContainer.style.right = '';
            subBubblesContainer.style.width = ''; subBubblesContainer.style.height = '';
            subBubblesContainer.style.flexDirection = ''; subBubblesContainer.style.padding = '';
            subBubblesContainer.style.justifyContent = '';

            if (isMobile) {
                // --- MOBILE: ĐỔ NGANG (HORIZONTAL) ---
                subBubblesContainer.style.width = 'max-content';
                subBubblesContainer.style.height = '60px';
                subBubblesContainer.style.flexDirection = 'row';
                subBubblesContainer.style.top = '0'; // Ngang bằng bong bóng chính

                if (rect.left > screenW / 2) {
                    // Bong bóng bên PHẢI -> Nút con mọc sang TRÁI
                    subBubblesContainer.style.right = '100%';
                    subBubblesContainer.style.paddingRight = '15px';
                    subBubblesContainer.style.justifyContent = 'flex-end';
                } else {
                    // Bong bóng bên TRÁI -> Nút con mọc sang PHẢI
                    subBubblesContainer.style.left = '100%';
                    subBubblesContainer.style.paddingLeft = '15px';
                    subBubblesContainer.style.justifyContent = 'flex-start';
                }
            } else {
                // --- DESKTOP: ĐỔ DỌC (VERTICAL) ---
                subBubblesContainer.style.width = '60px';
                subBubblesContainer.style.left = '0';
                subBubblesContainer.style.flexDirection = 'column';

                if (rect.top > screenH / 2) {
                    // Ở dưới -> Đổ lên
                    subBubblesContainer.style.bottom = '100%';
                    subBubblesContainer.style.paddingBottom = '15px';
                } else {
                    // Ở trên -> Đổ xuống
                    subBubblesContainer.style.top = '100%';
                    subBubblesContainer.style.paddingTop = '15px';
                }
            }
        }

        function openPopupContent(type) {
            currentMode = type;
            menuInterface.classList.add('d-none');
            chatInterface.classList.add('d-none');

            if (type === 'chat') {
                chatInterface.classList.remove('d-none');
                positionPopup('chat');
                popup.classList.add('active');
            } else {
                menuInterface.classList.remove('d-none');
                setTimeout(() => {
                    calculateMenuGrid();
                    positionPopup('menu');
                    popup.classList.add('active');
                }, 10);
            }
        }

        // --- [SMART LAYOUT LOGIC] ---
        function positionPopup(type) {
            const rect = wrapper.getBoundingClientRect();
            const screenW = window.innerWidth;
            const screenH = window.innerHeight;
            const isMobile = screenW < 992;
            const gap = 20; const edgePadding = 20;

            popup.style.display = 'block';
            if (type === 'chat') chatInterface.style.width = '';

            if (isMobile) {
                // --- MOBILE: POPUP NẰM TRÊN HOẶC DƯỚI BONG BÓNG ---
                // 1. Reset Left/Right -> Full màn hình
                popup.style.left = '20px';
                popup.style.right = '20px';
                popup.style.width = 'auto';
                popup.style.maxWidth = 'none';

                // 2. Tính Trên/Dưới
                if (rect.top > screenH / 2) {
                    // Bong bóng ở nửa dưới -> Popup hiện lên TRÊN
                    popup.style.bottom = (screenH - rect.top + gap) + 'px';
                    popup.style.top = 'auto';
                    popup.style.transformOrigin = 'bottom center';
                    popup.style.maxHeight = (rect.top - gap - edgePadding) + 'px';
                } else {
                    // Bong bóng ở nửa trên -> Popup hiện xuống DƯỚI
                    popup.style.top = (rect.bottom + gap) + 'px';
                    popup.style.bottom = 'auto';
                    popup.style.transformOrigin = 'top center';
                    popup.style.maxHeight = (screenH - rect.bottom - gap - edgePadding) + 'px';
                }

                chatInterface.style.width = '';

            } else {
                // --- DESKTOP: POPUP NẰM BÊN CẠNH ---
                popup.style.width = 'max-content';
                popup.style.maxWidth = '95vw';
                popup.style.maxHeight = 'none';

                let availableWidth = 0;
                if (rect.left > screenW / 2) {
                    popup.style.right = (screenW - rect.left + gap) + 'px';
                    popup.style.left = 'auto';
                    popup.style.transformOrigin = 'right center';
                    availableWidth = rect.left - gap - edgePadding;
                } else {
                    popup.style.left = (rect.right + gap) + 'px';
                    popup.style.right = 'auto';
                    popup.style.transformOrigin = 'left center';
                    availableWidth = screenW - rect.right - gap - edgePadding;
                }

                if (type === 'chat') {
                    let targetWidth = Math.min(availableWidth, 800);
                    if (targetWidth < 350) targetWidth = 350;
                    chatInterface.style.width = `${targetWidth}px`;
                }

                const pHeight = popup.scrollHeight;
                const bubbleCenterY = rect.top + (rect.height / 2);
                let top = bubbleCenterY - (pHeight / 2);
                if (top < 20) top = 20;
                if (top + pHeight > screenH - 20) top = screenH - pHeight - 20;
                popup.style.top = top + 'px';
                popup.style.bottom = 'auto';
            }

            popup.style.display = '';
        }

        function calculateMenuGrid() {
            const grid = menuInterface.querySelector('.popup-grid');
            if(grid) {
                grid.classList.remove('grid-cols-1', 'grid-cols-2', 'grid-cols-3', 'grid-cols-4');
                const rect = wrapper.getBoundingClientRect();
                const screenW = window.innerWidth;
                const minColWidth = 180;
                const gap = 20;

                let availW = (rect.left > screenW/2) ? (rect.left - gap) : (screenW - rect.right - gap);
                if(screenW < 992) availW = screenW - 40; // Mobile: Full width

                let cols = Math.floor(availW / minColWidth);
                if (cols > 4) cols = 4; if (cols < 1) cols = 1;
                grid.classList.add(`grid-cols-${cols}`);
            }
        }

        document.getElementById('btn-scroll-top').addEventListener('click', () => { window.scrollTo({ top: 0, behavior: 'smooth' }); closeAll(); });
        document.getElementById('btn-scroll-bottom').addEventListener('click', () => { window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' }); closeAll(); });
        document.getElementById('btn-open-chat').addEventListener('click', () => { openPopupContent('chat'); });
        backdrop.addEventListener('click', closeAll);

        window.openChat = function(id) { chatInterface.classList.add('in-conversation'); }
        window.backToChatList = function() { chatInterface.classList.remove('in-conversation'); }
    });
</script>
</body>
</html>
