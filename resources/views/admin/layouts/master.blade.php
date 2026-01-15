<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">

    <style>
        /* --- 1. RESET LAYOUT & FULL WIDTH --- */
        html, body {
            height: 100%; margin: 0; padding: 0; overflow-x: hidden;
        }

        #main-wrapper {
            width: 100% !important;
            margin-left: 0 !important;
            padding: 0 !important;
            min-height: 100vh;
            position: relative;
            z-index: 1;
            padding-bottom: 100px !important;
        }

        .admin-container {
            width: 100%;
            padding: 15px;
            margin: 0 auto;
        }

        @media (min-width: 998px) {
            .admin-container {
                padding: 30px;
                max-width: 1400px;
            }
        }

        /* --- 2. BIẾN MÀU (GIỮ NGUYÊN) --- */
        :root {
            /* Light Mode */
            --bg-body: #f8fafc;
            --text-color: #0f172a;
            --text-muted: #64748b;
            --popup-bg: rgba(255, 255, 255, 0.98);
            --popup-border: rgba(0, 0, 0, 0.06);
            --popup-shadow: 0 10px 40px -10px rgba(0,0,0,0.1);
            --link-hover-bg: #f1f5f9;
            --link-hover-text: #0284c7;
            --primary: #0ea5e9;
            --scrollbar-thumb: #cbd5e1;
        }

        body.dark-mode {
            /* Dark Mode */
            --bg-body: #020617;
            --text-color: #f8fafc;
            --text-muted: #94a3b8;
            --popup-bg: rgba(15, 23, 42, 0.98);
            --popup-border: rgba(255, 255, 255, 0.08);
            --popup-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
            --link-hover-bg: rgba(255, 255, 255, 0.08);
            --link-hover-text: #38bdf8;
            --primary: #38bdf8;
            --scrollbar-thumb: #334155;
        }

        body { background-color: var(--bg-body); color: var(--text-color); font-family: 'Segoe UI', sans-serif; transition: background-color 0.3s, color 0.3s; }
        body.no-select { user-select: none; -webkit-user-select: none; }

        /* --- 3. BONG BÓNG & POPUP --- */
        #nav-backdrop { position: fixed; inset: 0; background: rgba(0,0,0,0.3); z-index: 9998; opacity: 0; visibility: hidden; transition: 0.3s; backdrop-filter: blur(2px); }
        #nav-backdrop.active { opacity: 1; visibility: visible; }

        #bubble-wrapper { position: fixed; bottom: 40px; right: 40px; z-index: 10000; transition: transform 0.1s; }

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

        .sub-bubbles-container { position: absolute; left: 0; width: 60px; display: flex; flex-direction: column; align-items: center; gap: 10px; pointer-events: none; }
        .sub-bubble { width: 45px; height: 45px; background-color: var(--popup-bg); border: 1px solid var(--popup-border); color: var(--text-color); backdrop-filter: blur(10px); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); cursor: pointer; opacity: 0; transform: scale(0); transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        .sub-bubble:hover { background-color: var(--primary); color: #fff; border-color: var(--primary); }
        #bubble-wrapper.expanded .sub-bubble { opacity: 1; transform: scale(1); pointer-events: auto; }
        .badge-counter { position: absolute; top: -5px; right: -5px; background: #ef4444; color: white; font-size: 10px; padding: 2px 6px; border-radius: 10px; font-weight: bold; border: 2px solid var(--popup-bg); }

        /* --- [FIX QUAN TRỌNG] POPUP CONTAINER --- */
        #nav-popup {
            position: fixed; z-index: 9999;
            background: var(--popup-bg);
            backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--popup-border);
            box-shadow: var(--popup-shadow);
            border-radius: 20px;
            opacity: 0; visibility: hidden; transform: scale(0.95);
            transition: opacity 0.2s ease-out, transform 0.2s cubic-bezier(0.165, 0.84, 0.44, 1);

            /* SỬA LỖI SCROLL: Khóa cuộn ở thẻ cha, chuyển cuộn vào thẻ con */
            overflow: hidden;
            display: flex; flex-direction: column;
        }
        #nav-popup.active { opacity: 1; visibility: visible; transform: scale(1) translateX(0) translateY(0); }

        /* --- [FIX] MENU INTERFACE --- */
        #menu-interface {
            width: 100%;
            /* Thêm cuộn riêng cho menu */
            overflow-y: auto;
            max-height: 80vh; /* Giới hạn chiều cao để không bị tràn */
            scrollbar-width: thin;
        }
        #menu-interface::-webkit-scrollbar { width: 6px; }
        #menu-interface::-webkit-scrollbar-track { background: transparent; }
        #menu-interface::-webkit-scrollbar-thumb { background-color: var(--scrollbar-thumb); border-radius: 10px; }

        #menu-interface .popup-grid { display: grid; padding: 25px; gap: 20px; }
        .grid-cols-1 { grid-template-columns: 1fr; }
        .grid-cols-2 { grid-template-columns: repeat(2, 1fr); }
        .grid-cols-3 { grid-template-columns: repeat(3, 1fr); }
        .grid-cols-4 { grid-template-columns: repeat(4, 1fr); }

        .menu-column { display: flex; flex-direction: column; gap: 4px; }
        .group-title { font-size: 0.75rem; font-weight: 800; text-transform: uppercase; color: var(--text-muted); margin-bottom: 8px; margin-top: 16px; letter-spacing: 0.5px; }
        .group-title:first-child { margin-top: 0; }
        .menu-link { display: flex; align-items: center; padding: 8px 12px; color: var(--text-color); text-decoration: none; border-radius: 8px; font-weight: 500; font-size: 0.95rem; transition: all 0.2s; white-space: nowrap; }
        .menu-link:hover { background-color: var(--link-hover-bg); color: var(--link-hover-text); transform: translateX(4px); }
        .menu-link i { width: 24px; color: var(--text-muted); margin-right: 8px; text-align: center; transition: color 0.2s; }
        .menu-link:hover i { color: var(--link-hover-text); }
        .popup-header { padding: 15px 25px; border-bottom: 1px solid var(--popup-border); display: flex; align-items: center; justify-content: space-between; }

        /* --- [FIX] CHAT INTERFACE --- */
        #chat-interface {
            max-width: 800px; width: 800px;
            height: 500px; /* Chiều cao cố định */
            max-height: 100%; /* Không cao hơn popup cha */
            display: flex; flex-direction: column;
        }

        .chat-layout { position: relative; width: 100%; height: 100%; display: flex; overflow: hidden; }
        .chat-sidebar { width: 300px; height: 100%; border-right: 1px solid var(--popup-border); display: flex; flex-direction: column; background: rgba(0,0,0,0.01); }
        .chat-window { flex: 1; height: 100%; display: flex; flex-direction: column; background: transparent; }
        .chat-item:hover, .chat-item.active { background-color: var(--link-hover-bg); }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: var(--scrollbar-thumb); border-radius: 10px; }

        .mobile-nav-btn { display: none; }
        .desktop-nav-element { display: block; }

        @media (max-width: 997.98px) {
            #chat-interface { width: 100% !important; height: 70vh !important; max-width: none !important; }
            .chat-sidebar { width: 100%; height: 100%; position: absolute; inset: 0; z-index: 10; background: var(--popup-bg); transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1); transform: translateX(0); border-right: none; }
            .chat-window { width: 100%; height: 100%; position: absolute; inset: 0; z-index: 10; background: var(--popup-bg); transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1); transform: translateX(100%); }

            #chat-interface.in-conversation .chat-sidebar { transform: translateX(-20%); opacity: 0; pointer-events: none; }
            #chat-interface.in-conversation .chat-window { transform: translateX(0); }

            .mobile-nav-btn { display: block !important; }
            .desktop-nav-element { display: none !important; }
            #bubble-wrapper.expanded .sub-bubbles-container { z-index: 9990; }
        }

        /* Dark Mode overrides */
        body.dark-mode .text-dark { color: #f1f5f9 !important; }
        body.dark-mode .text-primary { color: #38bdf8 !important; }
        body.dark-mode .text-secondary { color: #cbd5e1 !important; }
        body.dark-mode .border-bottom { border-color: var(--popup-border) !important; }
        body.dark-mode .form-control { background-color: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1); color: #fff; }
        body.dark-mode .form-control:focus { background-color: rgba(255,255,255,0.08); border-color: var(--primary); color: #fff; box-shadow: none; }

        /* Theme Switch */
        .theme { display: flex; align-items: center; }
        .theme__toggle { width: 3.5em; height: 1.8em; -webkit-appearance: none; background: #cbd5e1; border-radius: 2em; position: relative; cursor: pointer; transition: 0.3s; }
        .theme__toggle::after { content: ''; position: absolute; left: 0.2em; top: 0.2em; width: 1.4em; height: 1.4em; background: #fff; border-radius: 50%; transition: 0.3s cubic-bezier(0.4, 0.0, 0.2, 1); box-shadow: 0 2px 5px rgba(0,0,0,0.2); }
        .theme__toggle:checked { background: #0f172a; }
        .theme__toggle:checked::after { left: 1.9em; transform: translateX(0); }
        .theme-switch-wrapper { transform: scale(0.9); }
    </style>
</head>
<body>

<div id="main-wrapper">
    <div class="admin-container">
        @yield('content')
    </div>
</div>

<div id="nav-backdrop"></div>

@include('admin.partials.bubbles')

<div id="nav-popup">
    <div id="menu-interface">
        @include('admin.partials.menu-popup')
    </div>
    @include('admin.partials.chat-popup')
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // --- LOGIC THEME ---
        const themeToggle = document.querySelector('#theme');
        const body = document.body;
        if(localStorage.getItem('admin_theme_preference') === 'dark') {
            body.classList.add('dark-mode');
            if(themeToggle) themeToggle.checked = true;
        }
        if(themeToggle) themeToggle.addEventListener('change', (e) => {
            if(e.target.checked) {
                body.classList.add('dark-mode');
                localStorage.setItem('admin_theme_preference', 'dark');
            } else {
                body.classList.remove('dark-mode');
                localStorage.setItem('admin_theme_preference', 'light');
            }
        });

        // --- LOGIC BONG BÓNG & POPUP ---
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

        const savedPos = localStorage.getItem('bubblePos_admin');
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
            wrapper.style.transition = 'none';
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

                let newLeft = initialLeft + (pos.clientX - startX);
                let newTop = initialTop + (pos.clientY - startY);

                const maxLeft = window.innerWidth - wrapper.offsetWidth;
                const maxTop = window.innerHeight - wrapper.offsetHeight;
                newLeft = Math.min(Math.max(0, newLeft), maxLeft);
                newTop = Math.min(Math.max(0, newTop), maxTop);

                wrapper.style.left = `${newLeft}px`;
                wrapper.style.top = `${newTop}px`;

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

            popup.style.transition = '';
            wrapper.style.transition = 'transform 0.1s';

            if (isDragging) {
                localStorage.setItem('bubblePos_admin', JSON.stringify({ left: wrapper.style.left, top: wrapper.style.top }));
                setTimeout(() => { isDragging = false; }, 50);
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
            setTimeout(() => { backToChatList(); }, 300);
        }

        function expandBubblesVisual() {
            const rect = wrapper.getBoundingClientRect();
            const screenW = window.innerWidth;
            const screenH = window.innerHeight;
            const isMobile = screenW < 998;

            subBubblesContainer.style.cssText = '';
            subBubblesContainer.style.position = 'absolute';
            subBubblesContainer.style.display = 'flex';
            subBubblesContainer.style.gap = '10px';
            subBubblesContainer.style.pointerEvents = 'none';

            if (isMobile) {
                subBubblesContainer.style.flexDirection = 'row';
                subBubblesContainer.style.top = '7.5px';
                subBubblesContainer.style.width = 'max-content';

                if (rect.left > screenW / 2) {
                    subBubblesContainer.style.right = '70px';
                    subBubblesContainer.style.left = 'auto';
                    subBubblesContainer.style.justifyContent = 'flex-end';
                } else {
                    subBubblesContainer.style.left = '70px';
                    subBubblesContainer.style.right = 'auto';
                    subBubblesContainer.style.justifyContent = 'flex-start';
                }
            } else {
                subBubblesContainer.style.width = '60px';
                subBubblesContainer.style.left = '0';
                subBubblesContainer.style.flexDirection = 'column';

                if (rect.top > screenH / 2) {
                    subBubblesContainer.style.bottom = '70px';
                    subBubblesContainer.style.top = 'auto';
                } else {
                    subBubblesContainer.style.top = '70px';
                    subBubblesContainer.style.bottom = 'auto';
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
                calculateMenuGrid();
                setTimeout(() => {
                    positionPopup('menu');
                    popup.classList.add('active');
                }, 10);
            }
        }

        function positionPopup(type) {
            const rect = wrapper.getBoundingClientRect();
            const screenW = window.innerWidth;
            const screenH = window.innerHeight;
            const gap = 15;
            const edgePadding = 20;

            popup.style.removeProperty('inset');
            popup.style.inset = '';
            popup.style.left = ''; popup.style.right = '';
            popup.style.top = ''; popup.style.bottom = '';
            popup.style.width = ''; popup.style.height = '';
            popup.style.maxWidth = ''; popup.style.maxHeight = '';
            popup.style.transformOrigin = '';
            popup.style.margin = '';
            popup.style.transform = '';

            if (type === 'chat') chatInterface.style.width = '';

            if (screenW < 998) {
                let vwUnit = 92;
                if (screenW >= 450) vwUnit = 88;
                popup.style.width = `${vwUnit}vw`;
                popup.style.maxWidth = `${vwUnit}vw`;
                popup.style.left = '50%';
                popup.style.transform = 'translateX(-50%)';

                let maxH = 0;
                if (rect.top > screenH / 2) {
                    popup.style.bottom = (screenH - rect.top + gap) + 'px';
                    popup.style.top = 'auto';
                    popup.style.transformOrigin = 'bottom center';
                    maxH = rect.top - gap - edgePadding;
                } else {
                    popup.style.top = (rect.bottom + gap) + 'px';
                    popup.style.bottom = 'auto';
                    popup.style.transformOrigin = 'top center';
                    maxH = screenH - rect.bottom - gap - edgePadding;
                }
                popup.style.maxHeight = maxH + 'px';
            } else {
                popup.style.width = 'max-content';
                popup.style.maxWidth = '95vw';

                if (type === 'chat') {
                    let availW = (rect.left > screenW / 2)
                        ? (rect.left - gap - edgePadding)
                        : (screenW - rect.right - gap - edgePadding);
                    let targetWidth = Math.min(availW, 800);
                    if (targetWidth < 350) targetWidth = 350;
                    chatInterface.style.width = `${targetWidth}px`;
                }

                if (rect.left > screenW / 2) {
                    popup.style.right = (screenW - rect.left + gap) + 'px';
                    popup.style.left = 'auto';
                    popup.style.transformOrigin = 'right center';
                } else {
                    popup.style.left = (rect.right + gap) + 'px';
                    popup.style.right = 'auto';
                    popup.style.transformOrigin = 'left center';
                }

                const pHeight = popup.scrollHeight;
                const bubbleCenterY = rect.top + (rect.height / 2);
                let idealTop = bubbleCenterY - (pHeight / 2);
                const minTop = 20;
                const maxTop = screenH - pHeight - 20;
                let finalTop = Math.max(minTop, Math.min(idealTop, maxTop));

                popup.style.top = finalTop + 'px';
                popup.style.bottom = 'auto';
                popup.style.maxHeight = (screenH - 40) + 'px';
            }
        }

        function calculateMenuGrid() {
            const grid = menuInterface.querySelector('.popup-grid');
            if(grid) {
                grid.classList.remove('grid-cols-1', 'grid-cols-2', 'grid-cols-3', 'grid-cols-4');
                const rect = wrapper.getBoundingClientRect();
                const screenW = window.innerWidth;
                const minColWidth = 160;
                const gap = 20;

                if (screenW < 576) {
                    grid.classList.add('grid-cols-1');
                } else if (screenW < 998) {
                    grid.classList.add('grid-cols-2');
                } else {
                    let availW = (rect.left > screenW/2) ? (rect.left - gap) : (screenW - rect.right - gap);
                    let cols = Math.floor(availW / minColWidth);
                    if (cols > 4) cols = 4; if (cols < 1) cols = 1;
                    grid.classList.add(`grid-cols-${cols}`);
                }
            }
        }

        const btnTop = document.getElementById('btn-scroll-top');
        const btnBottom = document.getElementById('btn-scroll-bottom');
        const btnChat = document.getElementById('btn-open-chat');

        if(btnTop) btnTop.addEventListener('click', () => { window.scrollTo({ top: 0, behavior: 'smooth' }); closeAll(); });
        if(btnBottom) btnBottom.addEventListener('click', () => { window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' }); closeAll(); });
        if(btnChat) btnChat.addEventListener('click', () => { openPopupContent('chat'); });

        backdrop.addEventListener('click', closeAll);

        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                if (isSystemOpen) {
                    expandBubblesVisual();
                    positionPopup(currentMode);
                    if(currentMode === 'menu') calculateMenuGrid();
                }
            }, 100);
        });

        window.openChat = function(id) {
            chatInterface.classList.add('in-conversation');
        }
        window.backToChatList = function() {
            chatInterface.classList.remove('in-conversation');
        }
    });
</script>
</body>
</html>
