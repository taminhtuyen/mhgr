<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        /* --- 1. DEFINING VARIABLES (THEMING) --- */
        :root {
            /* Light Mode (Mặc định) */
            --bg-body: #f0f2f5;
            --text-color: #334155;
            --text-muted: #94a3b8;

            /* Glassmorphism Variables Light */
            --popup-bg: rgba(255, 255, 255, 0.75); /* Kính sáng */
            --popup-border: rgba(255, 255, 255, 0.5);
            --popup-shadow: 0 10px 40px rgba(0,0,0,0.1);

            --link-hover-bg: #eff6ff;
            --link-hover-text: #2563eb;

            /* Switch Button Vars */
            --transDur: 0.3s;
            --primary: hsl(221, 90%, 55%);
            --primaryT: hsla(221, 90%, 55%, 0.2); /* Transparent primary */
        }

        /* Dark Mode Override */
        body.dark-mode {
            --bg-body: #0f172a; /* Nền tối đậm */
            --text-color: #e2e8f0; /* Chữ sáng */
            --text-muted: #94a3b8;

            /* Glassmorphism Variables Dark */
            --popup-bg: rgba(30, 41, 59, 0.7); /* Kính tối màu */
            --popup-border: rgba(255, 255, 255, 0.08);
            --popup-shadow: 0 10px 40px rgba(0,0,0,0.5);

            --link-hover-bg: rgba(255, 255, 255, 0.1);
            --link-hover-text: #60a5fa;
        }

        /* --- 2. GLOBAL STYLES --- */
        body {
            background-color: var(--bg-body);
            color: var(--text-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* VÙNG CONTENT CHÍNH */
        #main-wrapper {
            width: 100%;
            min-height: 100vh;
            padding: 20px;
            transition: all 0.3s ease;
        }

        /* --- 3. BACKDROP & BONG BÓNG --- */
        #nav-backdrop {
            position: fixed;
            top: 0; left: 0;
            width: 100vw; height: 100vh;
            background-color: rgba(0, 0, 0, 0.4);
            z-index: 9998;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease;
            backdrop-filter: blur(2px);
        }
        #nav-backdrop.active {
            opacity: 1;
            visibility: visible;
        }

        #nav-bubble {
            position: fixed;
            bottom: 40px;
            right: 40px;
            width: 60px; height: 60px;
            background: linear-gradient(135deg, #2563eb, #1e40af);
            color: #fff;
            border-radius: 50%;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.4);
            display: flex;
            align-items: center; justify-content: center;
            font-size: 24px;
            cursor: pointer;
            z-index: 10000;
            user-select: none;
            transition: transform 0.2s;
        }
        #nav-bubble:hover { transform: scale(1.1); }
        #nav-bubble:active { transform: scale(0.9); }

        /* --- 4. MENU POPUP (Glassmorphism Applied) --- */
        #nav-popup {
            position: fixed;
            z-index: 9999;

            /* KÍNH MỜ (Glass Effect) */
            background: var(--popup-bg);
            backdrop-filter: blur(16px); /* Làm mờ hậu cảnh mạnh hơn */
            -webkit-backdrop-filter: blur(16px); /* Cho Safari */
            border: 1px solid var(--popup-border);
            box-shadow: var(--popup-shadow);

            border-radius: 16px;

            opacity: 0;
            visibility: hidden;
            transform: scale(0.95);
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);

            max-width: 95vw;
            width: max-content;
            overflow-y: auto;
            scrollbar-width: thin;
        }

        #nav-popup.active {
            opacity: 1;
            visibility: visible;
            transform: scale(1);
        }

        .popup-header {
            padding: 15px 25px 0 25px;
            border-bottom-color: var(--popup-border) !important;
        }

        .popup-grid {
            display: flex;
            flex-direction: row;
            padding: 15px 25px 25px 25px;
            gap: 40px;
        }

        .menu-column {
            min-width: 170px;
            display: flex;
            flex-direction: column;
        }

        .group-title {
            font-size: 0.8rem;
            font-weight: 800;
            text-transform: uppercase;
            color: var(--text-muted); /* Sử dụng biến */
            margin-bottom: 12px;
            padding-bottom: 5px;
            border-bottom: 2px solid rgba(148, 163, 184, 0.2);
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        .group-spacer { margin-top: 25px; }

        .menu-link {
            display: flex; align-items: center;
            padding: 8px 10px;
            color: var(--text-color); /* Sử dụng biến */
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            border-radius: 8px;
            transition: 0.2s;
            white-space: nowrap;
            margin-bottom: 2px;
        }
        .menu-link:hover {
            background-color: var(--link-hover-bg);
            color: var(--link-hover-text);
            transform: translateX(3px);
        }
        .menu-link i {
            width: 24px;
            color: var(--text-muted);
            margin-right: 5px;
            font-size: 0.9em;
            text-align: center;
        }
        .menu-link:hover i { color: var(--link-hover-text); }

        /* --- XỬ LÝ MÀU BOOTSTRAP TRONG DARK MODE --- */
        /* Vì text-dark, text-primary mặc định của Bootstrap rất khó đọc trên nền tối, ta cần override */
        body.dark-mode .text-dark { color: #f1f5f9 !important; }
        body.dark-mode .text-primary { color: #60a5fa !important; }
        body.dark-mode .text-success { color: #4ade80 !important; }
        body.dark-mode .text-warning { color: #facc15 !important; }
        body.dark-mode .text-danger { color: #f87171 !important; }
        body.dark-mode .text-secondary { color: #cbd5e1 !important; }
        body.dark-mode .text-info { color: #38bdf8 !important; }

        @media (max-width: 992px) {
            .popup-grid { flex-wrap: wrap; }
        }
        @media (max-width: 576px) {
            .popup-grid { flex-direction: column; gap: 20px; }
            .menu-column { min-width: 100%; }
        }

        /* --- 5. SWITCH BUTTON STYLES (Embedded) --- */
        .theme {
            display: flex;
            align-items: center;
            -webkit-tap-highlight-color: transparent;
        }
        .theme__fill, .theme__icon { transition: 0.3s; }
        .theme__fill {
            background-color: var(--bg-body); /* Dùng biến nền body để fill */
            display: block;
            mix-blend-mode: difference;
            position: fixed;
            inset: 0;
            height: 100%;
            transform: translateX(-100%);
            pointer-events: none; /* Tránh che mất nội dung khi animation */
        }
        .theme__icon, .theme__toggle { z-index: 1; }
        .theme__icon, .theme__icon-part { position: absolute; }
        .theme__icon {
            display: block;
            top: 0.5em; left: 0.5em;
            width: 1.5em; height: 1.5em;
        }
        .theme__icon-part {
            border-radius: 50%;
            box-shadow: 0.4em -0.4em 0 0.5em hsl(0,0%,100%) inset;
            top: calc(50% - 0.5em); left: calc(50% - 0.5em);
            width: 1em; height: 1em;
            transition: box-shadow var(--transDur) ease-in-out, opacity var(--transDur) ease-in-out, transform var(--transDur) ease-in-out;
            transform: scale(0.5);
        }
        .theme__icon-part ~ .theme__icon-part {
            background-color: hsl(0,0%,100%);
            border-radius: 0.05em;
            top: 50%; left: calc(50% - 0.05em);
            transform: rotate(0deg) translateY(0.5em);
            transform-origin: 50% 0;
            width: 0.1em; height: 0.2em;
        }
        /* Các tia nắng */
        .theme__icon-part:nth-child(3) { transform: rotate(45deg) translateY(0.45em); }
        .theme__icon-part:nth-child(4) { transform: rotate(90deg) translateY(0.45em); }
        .theme__icon-part:nth-child(5) { transform: rotate(135deg) translateY(0.45em); }
        .theme__icon-part:nth-child(6) { transform: rotate(180deg) translateY(0.45em); }
        .theme__icon-part:nth-child(7) { transform: rotate(225deg) translateY(0.45em); }
        .theme__icon-part:nth-child(8) { transform: rotate(270deg) translateY(0.5em); }
        .theme__icon-part:nth-child(9) { transform: rotate(315deg) translateY(0.5em); }

        .theme__label, .theme__toggle, .theme__toggle-wrap { position: relative; }
        .theme__toggle, .theme__toggle:before { display: block; }
        .theme__toggle {
            background-color: hsl(48,90%,85%);
            border-radius: 25% / 50%;
            box-shadow: 0 0 0 0.125em var(--primaryT);
            padding: 0.25em;
            width: 6em; height: 3em;
            -webkit-appearance: none; appearance: none;
            transition: background-color var(--transDur) ease-in-out, box-shadow 0.15s ease-in-out, transform var(--transDur) ease-in-out;
            cursor: pointer;
        }
        .theme__toggle:before {
            background-color: hsl(48,90%,55%);
            border-radius: 50%;
            content: "";
            width: 2.5em; height: 2.5em;
            transition: 0.3s;
        }
        .theme__toggle:focus { box-shadow: 0 0 0 0.125em var(--primary); outline: transparent; }
        /* Checked State */
        .theme__toggle:checked { background-color: hsl(198,90%,15%); }
        .theme__toggle:checked:before, .theme__toggle:checked ~ .theme__icon { transform: translateX(3em); }
        .theme__toggle:checked:before { background-color: hsl(198,90%,55%); }
        .theme__toggle:checked ~ .theme__fill { transform: translateX(0); }
        .theme__toggle:checked ~ .theme__icon .theme__icon-part:nth-child(1) {
            box-shadow: 0.2em -0.2em 0 0.2em hsl(0,0%,100%) inset;
            transform: scale(1); top: 0.2em; left: -0.2em;
        }
        .theme__toggle:checked ~ .theme__icon .theme__icon-part ~ .theme__icon-part { opacity: 0; }
        .theme__toggle:checked ~ .theme__icon .theme__icon-part:nth-child(2) { transform: rotate(45deg) translateY(0.8em); }
        .theme__toggle:checked ~ .theme__icon .theme__icon-part:nth-child(3) { transform: rotate(90deg) translateY(0.8em); }
        .theme__toggle:checked ~ .theme__icon .theme__icon-part:nth-child(4) { transform: rotate(135deg) translateY(0.8em); }
        .theme__toggle:checked ~ .theme__icon .theme__icon-part:nth-child(5) { transform: rotate(180deg) translateY(0.8em); }
        .theme__toggle:checked ~ .theme__icon .theme__icon-part:nth-child(6) { transform: rotate(225deg) translateY(0.8em); }
        .theme__toggle:checked ~ .theme__icon .theme__icon-part:nth-child(7) { transform: rotate(270deg) translateY(0.8em); }
        .theme__toggle:checked ~ .theme__icon .theme__icon-part:nth-child(8) { transform: rotate(315deg) translateY(0.8em); }
        .theme__toggle:checked ~ .theme__icon .theme__icon-part:nth-child(9) { transform: rotate(360deg) translateY(0.8em); }
        .theme__toggle-wrap { margin: 0 0.75em; }

        @supports selector(:focus-visible) {
            .theme__toggle:focus { box-shadow: 0 0 0 0.125em var(--primaryT); }
            .theme__toggle:focus-visible { box-shadow: 0 0 0 0.125em var(--primary); }
        }
        /* Thu nhỏ switch một chút cho vừa menu */
        .theme-switch-wrapper { transform: scale(0.6); transform-origin: right center; }
    </style>
</head>
<body>

<div id="nav-backdrop"></div>

<div id="main-wrapper">
    @yield('content')
</div>

<div id="nav-bubble" title="Menu">
    <i class="fa-solid fa-bars" id="bubble-icon"></i>
</div>

<div id="nav-popup">
    {{-- Include file Menu riêng tại đây --}}
    @include('admin.partials.menu-popup')
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // --- 1. XỬ LÝ THEME (NGÀY/ĐÊM) ---
        const themeToggle = document.querySelector('#theme'); // Input checkbox
        const body = document.body;
        const STORAGE_KEY = 'admin_theme_preference';

        // Load cài đặt cũ từ LocalStorage
        const savedTheme = localStorage.getItem(STORAGE_KEY);
        if (savedTheme === 'dark') {
            body.classList.add('dark-mode');
            if(themeToggle) themeToggle.checked = true;
        }

        // Sự kiện khi bấm nút switch
        if(themeToggle) {
            themeToggle.addEventListener('change', (e) => {
                if (e.target.checked) {
                    body.classList.add('dark-mode');
                    localStorage.setItem(STORAGE_KEY, 'dark');
                } else {
                    body.classList.remove('dark-mode');
                    localStorage.setItem(STORAGE_KEY, 'light');
                }
            });
        }

        // --- 2. LOGIC MENU CŨ (GIỮ NGUYÊN) ---
        const bubble = document.getElementById('nav-bubble');
        const popup = document.getElementById('nav-popup');
        const backdrop = document.getElementById('nav-backdrop');
        const icon = document.getElementById('bubble-icon');

        let isDragging = false;
        let startX, startY, initialLeft, initialTop;

        const savedPos = localStorage.getItem('bubblePos');
        if (savedPos) {
            const pos = JSON.parse(savedPos);
            bubble.style.left = pos.left;
            bubble.style.top = pos.top;
            bubble.style.right = 'auto'; bubble.style.bottom = 'auto';
        }

        bubble.addEventListener('mousedown', (e) => {
            isDragging = false;
            startX = e.clientX; startY = e.clientY;
            const rect = bubble.getBoundingClientRect();
            initialLeft = rect.left; initialTop = rect.top;
            document.addEventListener('mousemove', onMouseMove);
            document.addEventListener('mouseup', onMouseUp);
        });

        function onMouseMove(e) {
            const dx = e.clientX - startX;
            const dy = e.clientY - startY;
            if (Math.abs(dx) > 5 || Math.abs(dy) > 5) {
                isDragging = true;
                closeMenu();
                bubble.style.left = `${initialLeft + dx}px`;
                bubble.style.top = `${initialTop + dy}px`;
                bubble.style.right = 'auto'; bubble.style.bottom = 'auto';
            }
        }

        function onMouseUp() {
            document.removeEventListener('mousemove', onMouseMove);
            document.removeEventListener('mouseup', onMouseUp);
            if (isDragging) {
                localStorage.setItem('bubblePos', JSON.stringify({
                    left: bubble.style.left, top: bubble.style.top
                }));
            }
        }

        bubble.addEventListener('click', () => {
            if (isDragging) return;
            if (popup.classList.contains('active')) {
                closeMenu();
            } else {
                openMenu();
            }
        });

        function openMenu() {
            const bubbleRect = bubble.getBoundingClientRect();
            const screenW = window.innerWidth;
            const screenH = window.innerHeight;
            const gap = 15;

            popup.style.top = 'auto'; popup.style.bottom = 'auto';
            popup.style.left = 'auto'; popup.style.right = 'auto';
            popup.style.maxHeight = 'none';

            if (bubbleRect.left > screenW / 2) {
                popup.style.right = (screenW - bubbleRect.left + gap) + 'px';
                popup.style.left = 'auto';
                popup.style.transformOrigin = 'bottom right';
            } else {
                popup.style.left = (bubbleRect.right + gap) + 'px';
                popup.style.right = 'auto';
                popup.style.transformOrigin = 'bottom left';
            }

            if (bubbleRect.top > screenH / 2) {
                popup.style.bottom = (screenH - bubbleRect.bottom) + 'px';
                popup.style.top = 'auto';
                popup.style.maxHeight = (bubbleRect.bottom - 20) + 'px';
                popup.style.transformOrigin = popup.style.transformOrigin.replace('top', 'bottom');
            } else {
                popup.style.top = bubbleRect.top + 'px';
                popup.style.bottom = 'auto';
                popup.style.maxHeight = (screenH - bubbleRect.top - 20) + 'px';
                popup.style.transformOrigin = popup.style.transformOrigin.replace('bottom', 'top');
            }

            popup.classList.add('active');
            backdrop.classList.add('active');
            icon.classList.replace('fa-bars', 'fa-xmark');
        }

        function closeMenu() {
            popup.classList.remove('active');
            backdrop.classList.remove('active');
            icon.classList.replace('fa-xmark', 'fa-bars');
        }

        backdrop.addEventListener('click', closeMenu);
    });
</script>
</body>
</html>
