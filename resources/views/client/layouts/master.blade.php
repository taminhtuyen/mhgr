<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cửa Hàng Trực Tuyến')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">
    {{-- Thêm Bootstrap JS Bundle để Dropdown hoạt động --}}
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    @livewireStyles

    <style>
        /* --- 1. RESET LAYOUT & FULL WIDTH --- */
        html, body {
            height: 100%; margin: 0; padding: 0; overflow: hidden;
            font-family: 'Segoe UI', sans-serif; transition: background-color 0.3s, color 0.3s;
        }

        /* --- 2. MAIN WRAPPER: CHỊU TRÁCH NHIỆM CUỘN --- */
        #main-wrapper {
            width: 100%; height: 100%; overflow-y: auto; overflow-x: hidden;
            position: relative; z-index: 1; padding-bottom: 100px;
            -webkit-overflow-scrolling: touch; scroll-behavior: smooth;
        }
        #main-wrapper::-webkit-scrollbar { width: 8px; }
        #main-wrapper::-webkit-scrollbar-track { background: transparent; }
        #main-wrapper::-webkit-scrollbar-thumb { background-color: var(--scrollbar-thumb); border-radius: 10px; }

        /* --- 3. BIẾN MÀU (CẬP NHẬT THEO ADMIN - GLASSMORPHISM) --- */
        :root {
            /* Light Mode */
            --bg-body: #ffffff;
            --text-color: #1e293b;
            --text-muted: #64748b;

            /* Nền trong suốt */
            --popup-bg: rgba(255, 255, 255, 0.95);
            --popup-border: rgba(0, 0, 0, 0.08);
            --popup-shadow: 0 20px 50px rgba(0,0,0,0.12);

            --link-hover-bg: #f0f9ff;
            --link-hover-text: #0ea5e9;
            --primary: #0ea5e9;
            --scrollbar-thumb: #cbd5e1;

            /* Input tối hơn nền [MỚI] */
            --input-darker: #f1f5f9;
        }

        body.dark-mode {
            /* Dark Mode */
            --bg-body: #0f172a;
            --text-color: #f1f5f9;
            --text-muted: #94a3b8;

            /* Nền tối trong suốt */
            --popup-bg: rgba(15, 23, 42, 0.95);
            --popup-border: rgba(255, 255, 255, 0.1);
            --popup-shadow: 0 20px 50px rgba(0,0,0,0.5);

            --link-hover-bg: rgba(255, 255, 255, 0.05);
            --link-hover-text: #38bdf8;
            --primary: #38bdf8;
            --scrollbar-thumb: #334155;

            /* Input tối hơn nền [MỚI] */
            --input-darker: #0b1120;
        }

        body { background-color: var(--bg-body); color: var(--text-color); }
        body.no-select { user-select: none; -webkit-user-select: none; }

        /* Utility Class */
        .cursor-pointer { cursor: pointer !important; }

        /* Class hiệu ứng kính mờ (Glassmorphism) [MỚI] */
        .glass-effect {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        /* --- 4. CÁC THÀNH PHẦN NỔI (POPUP/BUBBLES) --- */
        #nav-backdrop { position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 9998; opacity: 0; visibility: hidden; transition: 0.3s; backdrop-filter: blur(2px); }
        #nav-backdrop.active { opacity: 1; visibility: visible; }

        #bubble-wrapper { position: fixed; bottom: 30px; right: 30px; z-index: 10000; transition: transform 0.1s; }
        #nav-bubble { width: 60px; height: 60px; background: linear-gradient(135deg, #0ea5e9, #0284c7); color: #fff; border-radius: 50%; box-shadow: 0 4px 15px rgba(14, 165, 233, 0.4); display: flex; align-items: center; justify-content: center; font-size: 24px; cursor: pointer; transition: transform 0.2s; position: relative; z-index: 2; }
        #nav-bubble:hover { transform: scale(1.05); } #nav-bubble:active { transform: scale(0.95); }

        /* Styles cho chấm đỏ thông báo */
        .main-bubble-badge {
            position: absolute; top: 0px; right: 0px; width: 18px; height: 18px;
            background-color: #ef4444; border: 2px solid #fff; border-radius: 50%;
            display: block; box-shadow: 0 2px 5px rgba(0,0,0,0.2); z-index: 10;
        }
        body.dark-mode .main-bubble-badge { border-color: #0f172a; }

        .sub-bubbles-container { position: absolute; left: 0; width: 60px; display: flex; flex-direction: column; align-items: center; gap: 10px; pointer-events: none; }
        .sub-bubble { width: 45px; height: 45px; background-color: var(--popup-bg); border: 1px solid var(--popup-border); color: var(--text-color); backdrop-filter: blur(10px); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); cursor: pointer; opacity: 0; transform: scale(0); transition: all 0.3s; }
        .sub-bubble:hover { background-color: var(--primary); color: #fff; }
        #bubble-wrapper.expanded .sub-bubble { opacity: 1; transform: scale(1); pointer-events: auto; }
        .badge-counter { position: absolute; top: -5px; right: -5px; background: #ef4444; color: white; font-size: 10px; padding: 2px 6px; border-radius: 10px; font-weight: bold; }

        /* Popup Container - Có glass-effect */
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
            overflow: hidden; display: flex; flex-direction: column; overscroll-behavior: contain;
        }
        #nav-popup.active { opacity: 1; visibility: visible; transform: scale(1); }

        #menu-interface { width: 100%; overflow-y: auto; max-height: 80vh; scrollbar-width: thin; overscroll-behavior: contain; }
        #menu-interface::-webkit-scrollbar { width: 6px; } #menu-interface::-webkit-scrollbar-track { background: transparent; } #menu-interface::-webkit-scrollbar-thumb { background-color: var(--scrollbar-thumb); border-radius: 10px; }
        #menu-interface .popup-grid { display: grid; padding: 25px; gap: 25px; }
        .grid-cols-1 { grid-template-columns: 1fr; } .grid-cols-2 { grid-template-columns: repeat(2, 1fr); } .grid-cols-3 { grid-template-columns: repeat(3, 1fr); } .grid-cols-4 { grid-template-columns: repeat(4, 1fr); }
        .menu-column { display: flex; flex-direction: column; }
        .group-title { font-size: 0.8rem; font-weight: 800; text-transform: uppercase; color: var(--text-muted); margin-bottom: 12px; border-bottom: 2px solid rgba(148,163,184,0.2); }
        .menu-link { display: flex; align-items: center; padding: 8px 10px; color: var(--text-color); text-decoration: none; border-radius: 8px; font-weight: 500; transition: 0.2s; white-space: nowrap; margin-bottom: 2px; }
        .menu-link:hover { background-color: var(--link-hover-bg); color: var(--link-hover-text); transform: translateX(3px); }
        .menu-link i { width: 24px; color: var(--text-muted); margin-right: 5px; text-align: center; }
        .popup-header { padding: 15px 25px 0 25px; border-bottom: 1px solid var(--popup-border); }

        #chat-interface { max-width: 800px; width: 800px; height: 500px; max-height: 100%; display: flex; flex-direction: column; }
        .chat-layout { position: relative; width: 100%; height: 100%; display: flex; overflow: hidden; }
        .chat-sidebar { width: 300px; background: rgba(0,0,0,0.02); height: 100%; display: flex; flex-direction: column; }
        .chat-window { background: transparent; height: 100%; display: flex; flex-direction: column; }
        .chat-list, .chat-messages { overscroll-behavior: contain; }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; } .custom-scrollbar::-webkit-scrollbar-track { background: transparent; } .custom-scrollbar::-webkit-scrollbar-thumb { background: var(--scrollbar-thumb); border-radius: 10px; }

        /* Dropdown custom */
        .chat-sidebar .dropdown-menu { border: 1px solid var(--popup-border); box-shadow: var(--popup-shadow); background-color: var(--popup-bg); backdrop-filter: blur(10px); }
        .chat-sidebar .dropdown-item { color: var(--text-color); }
        .chat-sidebar .dropdown-item:hover { background-color: var(--link-hover-bg); color: var(--link-hover-text); }

        .mobile-nav-btn { display: none; } .desktop-nav-element { display: block; }

        @media (max-width: 997.98px) {
            #chat-interface { width: 100% !important; height: 70vh !important; max-width: none !important; }
            .chat-sidebar { width: 100%; height: 100%; position: absolute; inset: 0; z-index: 2; background: var(--popup-bg); transition: transform 0.3s; transform: translateX(0); }
            .chat-window { width: 100%; height: 100%; position: absolute; inset: 0; z-index: 2; background: var(--popup-bg); transition: transform 0.3s; transform: translateX(100%); }
            #chat-interface.in-conversation .chat-sidebar { transform: translateX(-100%); }
            #chat-interface.in-conversation .chat-window { transform: translateX(0); }
            .mobile-nav-btn { display: block !important; } .desktop-nav-element { display: none !important; }
        }

        .theme { display: flex; align-items: center; } .theme__toggle { width: 4em; height: 2em; -webkit-appearance: none; background: #cbd5e1; border-radius: 2em; position: relative; cursor: pointer; transition: 0.3s; } .theme__toggle::after { content: ''; position: absolute; left: 0.2em; top: 0.2em; width: 1.6em; height: 1.6em; background: #fff; border-radius: 50%; transition: 0.3s; } .theme__toggle:checked { background: #0f172a; } .theme__toggle:checked::after { left: 2.2em; } .theme-switch-wrapper { transform: scale(0.8); }
    </style>
</head>
<body>

{{-- CÁC THÀNH PHẦN NỔI --}}
<div id="nav-backdrop"></div>
@include('client.partials.bubbles')

<div id="nav-popup">
    <div id="menu-interface">
        @include('client.partials.menu-popup')
    </div>
    @include('client.partials.chat-popup')
</div>

{{-- VÙNG NỘI DUNG CHÍNH --}}
<div id="main-wrapper">
    {{ $slot ?? '' }}
    @yield('content')
</div>

@livewireScripts

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // --- 1. THEME LOGIC ---
        const themeToggle = document.querySelector('#theme'); const body = document.body;
        if(localStorage.getItem('client_theme_preference') === 'dark') { body.classList.add('dark-mode'); if(themeToggle) themeToggle.checked = true; }
        if(themeToggle) themeToggle.addEventListener('change', (e) => { body.classList.toggle('dark-mode', e.target.checked); localStorage.setItem('client_theme_preference', e.target.checked ? 'dark' : 'light'); });

        // --- 2. BUBBLES LOGIC ---
        const wrapper = document.getElementById('bubble-wrapper');
        const mainBubble = document.getElementById('nav-bubble');
        const subBubblesContainer = wrapper.querySelector('.sub-bubbles-container');
        const popup = document.getElementById('nav-popup');
        const backdrop = document.getElementById('nav-backdrop');
        const icon = document.getElementById('bubble-icon');
        const menuInterface = document.getElementById('menu-interface');
        const chatInterface = document.getElementById('chat-interface');
        const mainWrapper = document.getElementById('main-wrapper');

        let isDragging = false; let startX, startY, initialLeft, initialTop;
        let isSystemOpen = false; let currentMode = 'menu';

        const savedPos = localStorage.getItem('client_bubblePos');
        if (savedPos) { const pos = JSON.parse(savedPos); wrapper.style.left = pos.left; wrapper.style.top = pos.top; wrapper.style.bottom = 'auto'; wrapper.style.right = 'auto'; }
        const getClientPos = (e) => e.touches ? e.touches[0] : e;

        // --- HÀM DRAG START ---
        const onDragStart = (e) => {
            isDragging = false;
            const pos = getClientPos(e);
            startX = pos.clientX; startY = pos.clientY;

            const rect = wrapper.getBoundingClientRect();
            initialLeft = rect.left;
            initialTop = rect.top;

            wrapper.style.left = rect.left + 'px';
            wrapper.style.top = rect.top + 'px';
            wrapper.style.bottom = 'auto';
            wrapper.style.right = 'auto';

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
                isDragging = true; if(e.cancelable) e.preventDefault();

                let newLeft = initialLeft + (pos.clientX - startX);
                let newTop = initialTop + (pos.clientY - startY);

                const maxLeft = window.innerWidth - wrapper.offsetWidth;
                const maxTop = window.innerHeight - wrapper.offsetHeight;
                newLeft = Math.min(Math.max(0, newLeft), maxLeft);
                newTop = Math.min(Math.max(0, newTop), maxTop);

                wrapper.style.left = `${newLeft}px`;
                wrapper.style.top = `${newTop}px`;

                if (isSystemOpen) { expandBubblesVisual(); positionPopup(currentMode); }
            }
        };

        const onDragEnd = () => {
            document.removeEventListener('mousemove', onDragMove); document.removeEventListener('mouseup', onDragEnd);
            document.removeEventListener('touchmove', onDragMove); document.removeEventListener('touchend', onDragEnd);
            document.body.classList.remove('no-select');

            popup.style.transition = 'opacity 0.2s, transform 0.2s';
            wrapper.style.transition = 'transform 0.1s';

            if (isDragging) {
                localStorage.setItem('client_bubblePos', JSON.stringify({ left: wrapper.style.left, top: wrapper.style.top }));
                setTimeout(() => { isDragging = false; }, 50);
            }
        };

        mainBubble.addEventListener('mousedown', onDragStart); mainBubble.addEventListener('touchstart', onDragStart, { passive: false });
        mainBubble.onclick = (e) => { if (isDragging) return; if (e.cancelable && e.type === 'touchend') e.preventDefault(); if (isSystemOpen) closeAll(); else openAll('menu'); };

        // --- 3. OPEN/CLOSE LOGIC ---
        function openAll(mode) {
            isSystemOpen = true; currentMode = mode;
            expandBubblesVisual(); openPopupContent(mode);
            wrapper.classList.add('expanded'); icon.classList.replace('fa-bars', 'fa-xmark'); backdrop.classList.add('active');
        }

        function closeAll() {
            isSystemOpen = false;
            wrapper.classList.remove('expanded'); popup.classList.remove('active');
            icon.classList.replace('fa-xmark', 'fa-bars'); backdrop.classList.remove('active');
        }

        // --- CÁC HÀM TÍNH TOÁN VỊ TRÍ ---
        function expandBubblesVisual() {
            const rect = wrapper.getBoundingClientRect(); const screenW = window.innerWidth; const screenH = window.innerHeight; const isMobile = screenW < 998;
            subBubblesContainer.style.cssText = ''; subBubblesContainer.style.position = 'absolute'; subBubblesContainer.style.width = 'max-content'; subBubblesContainer.style.height = '60px'; subBubblesContainer.style.display = 'flex'; subBubblesContainer.style.gap = '10px'; subBubblesContainer.style.pointerEvents = 'none';
            if (isMobile) {
                subBubblesContainer.style.flexDirection = 'row'; subBubblesContainer.style.top = '0';
                if (rect.left > screenW / 2) { subBubblesContainer.style.right = '100%'; subBubblesContainer.style.left = 'auto'; subBubblesContainer.style.paddingRight = '15px'; subBubblesContainer.style.justifyContent = 'flex-end'; } else { subBubblesContainer.style.left = '100%'; subBubblesContainer.style.right = 'auto'; subBubblesContainer.style.paddingLeft = '15px'; subBubblesContainer.style.justifyContent = 'flex-start'; }
            } else {
                subBubblesContainer.style.width = '60px'; subBubblesContainer.style.height = 'auto'; subBubblesContainer.style.left = '0'; subBubblesContainer.style.flexDirection = 'column';
                if (rect.top > screenH / 2) { subBubblesContainer.style.bottom = '100%'; subBubblesContainer.style.paddingBottom = '15px'; } else { subBubblesContainer.style.top = '100%'; subBubblesContainer.style.paddingTop = '15px'; }
            }
        }
        function openPopupContent(type) {
            currentMode = type; menuInterface.classList.add('d-none'); chatInterface.classList.add('d-none');
            if (type === 'chat') { chatInterface.classList.remove('d-none'); positionPopup('chat'); popup.classList.add('active'); } else { menuInterface.classList.remove('d-none'); setTimeout(() => { calculateMenuGrid(); positionPopup('menu'); popup.classList.add('active'); }, 10); }
        }
        function positionPopup(type) {
            const rect = wrapper.getBoundingClientRect(); const screenW = window.innerWidth; const screenH = window.innerHeight; const gap = 20; const edgePadding = 20;
            popup.style.display = 'flex'; popup.style.removeProperty('inset'); popup.style.inset = ''; popup.style.left = ''; popup.style.right = ''; popup.style.top = ''; popup.style.bottom = ''; popup.style.width = ''; popup.style.height = ''; popup.style.maxWidth = ''; popup.style.maxHeight = ''; popup.style.margin = ''; popup.style.transformOrigin = '';
            if (type === 'chat') chatInterface.style.width = '';
            if (screenW < 998) {
                let vwUnit = 88; if (screenW < 400) vwUnit = 92; else if (screenW >= 400 && screenW <= 450) vwUnit = 90;
                popup.style.width = `${vwUnit}vw`; popup.style.maxWidth = `${vwUnit}vw`; popup.style.left = '50%'; popup.style.transform = 'translateX(-50%)';
                let maxH = 0;
                if (rect.top > screenH / 2) { popup.style.bottom = (screenH - rect.top + gap) + 'px'; popup.style.top = 'auto'; popup.style.transformOrigin = 'bottom center'; maxH = rect.top - gap - edgePadding; } else { popup.style.top = (rect.bottom + gap) + 'px'; popup.style.bottom = 'auto'; popup.style.transformOrigin = 'top center'; maxH = screenH - rect.bottom - gap - edgePadding; }
                popup.style.maxHeight = maxH + 'px';
            } else {
                popup.style.width = 'max-content'; popup.style.maxWidth = '95vw';
                let availableWidth = 0;
                if (rect.left > screenW / 2) { popup.style.right = (screenW - rect.left + gap) + 'px'; popup.style.left = 'auto'; popup.style.transformOrigin = 'right center'; availableWidth = rect.left - gap - edgePadding; } else { popup.style.left = (rect.right + gap) + 'px'; popup.style.right = 'auto'; popup.style.transformOrigin = 'left center'; availableWidth = screenW - rect.right - gap - edgePadding; }
                if (type === 'chat') { let targetWidth = Math.min(availableWidth, 800); if (targetWidth < 350) targetWidth = 350; chatInterface.style.width = `${targetWidth}px`; }
                const pHeight = popup.scrollHeight; const bubbleCenterY = rect.top + (rect.height / 2); let idealTop = bubbleCenterY - (pHeight / 2); const minTop = 20; const maxTop = screenH - pHeight - 20; let finalTop = Math.max(minTop, Math.min(idealTop, maxTop));
                popup.style.top = finalTop + 'px'; popup.style.bottom = 'auto'; popup.style.maxHeight = (screenH - 40) + 'px';
            }
        }
        function calculateMenuGrid() {
            const grid = menuInterface.querySelector('.popup-grid');
            if(grid) {
                grid.classList.remove('grid-cols-1', 'grid-cols-2', 'grid-cols-3', 'grid-cols-4');
                const rect = wrapper.getBoundingClientRect(); const screenW = window.innerWidth; const minColWidth = 180; const gap = 20;
                if (screenW < 576) { grid.classList.add('grid-cols-1'); } else if (screenW < 998) { grid.classList.add('grid-cols-2'); } else { let availW = (rect.left > screenW/2) ? (rect.left - gap) : (screenW - rect.right - gap); let cols = Math.floor(availW / minColWidth); if (cols > 4) cols = 4; if (cols < 1) cols = 1; grid.classList.add(`grid-cols-${cols}`); }
            }
        }

        const btnTop = document.getElementById('btn-scroll-top');
        const btnBottom = document.getElementById('btn-scroll-bottom');
        const btnChat = document.getElementById('btn-open-chat');

        if(btnTop) btnTop.addEventListener('click', () => {
            mainWrapper.scrollTo({ top: 0, behavior: 'smooth' });
            closeAll();
        });
        if(btnBottom) btnBottom.addEventListener('click', () => {
            mainWrapper.scrollTo({ top: mainWrapper.scrollHeight, behavior: 'smooth' });
            closeAll();
        });
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

        window.openChat = function(id) { chatInterface.classList.add('in-conversation'); }
        window.backToChatList = function() { chatInterface.classList.remove('in-conversation'); }
    });
</script>
</body>
</html>
