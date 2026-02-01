<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cửa Hàng Trực Tuyến')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    @livewireStyles

    @stack('styles')

    <style>
        /* --- GLOBAL VARIABLES & RESET --- */
        :root {
            /* Light Mode */
            --bg-body: #ffffff;
            --text-color: #1e293b;
            --text-muted: #64748b;
            --popup-bg: rgba(255, 255, 255, 0.95);
            --popup-border: rgba(0, 0, 0, 0.08);
            --popup-shadow: 0 20px 50px rgba(0,0,0,0.12);
            --link-hover-bg: #f0f9ff;
            --link-hover-text: #0ea5e9;
            --primary: #0ea5e9;
            --scrollbar-thumb: #cbd5e1;

            /* NEON CORE CONFIG */
            --neon-duration: 0.5s;

            /* Modal Colors */
            --modal-bg: rgba(255, 255, 255, 0.9);
            --modal-text: #000;
            --modal-border: rgba(60, 60, 67, 0.29);
        }

        body.dark-mode {
            /* Dark Mode */
            --bg-body: #0f172a;
            --text-color: #f1f5f9;
            --text-muted: #94a3b8;
            --popup-bg: rgba(15, 23, 42, 0.95);
            --popup-border: rgba(255, 255, 255, 0.1);
            --popup-shadow: 0 20px 50px rgba(0,0,0,0.5);
            --link-hover-bg: rgba(255, 255, 255, 0.05);
            --link-hover-text: #38bdf8;
            --primary: #38bdf8;
            --scrollbar-thumb: #334155;

            --modal-bg: rgba(30, 30, 30, 0.9);
            --modal-text: #fff;
            --modal-border: rgba(84, 84, 88, 0.65);
        }

        /* Layout cơ bản */
        html, body { height: 100%; margin: 0; padding: 0; overflow: hidden; font-family: 'Segoe UI', sans-serif; transition: background-color 0.3s, color 0.3s; background-color: var(--bg-body); color: var(--text-color); }
        body.no-select { user-select: none; -webkit-user-select: none; }

        /* Main Wrapper */
        #main-wrapper { width: 100%; height: 100%; overflow-y: auto; overflow-x: hidden; position: relative; z-index: 1; padding-bottom: 100px; -webkit-overflow-scrolling: touch; scroll-behavior: smooth; }
        #main-wrapper::-webkit-scrollbar { width: 8px; }
        #main-wrapper::-webkit-scrollbar-track { background: transparent; }
        #main-wrapper::-webkit-scrollbar-thumb { background-color: var(--scrollbar-thumb); border-radius: 10px; }

        /* Utility */
        .glass-effect { backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
        .cursor-pointer { cursor: pointer !important; }

        /* Global Modal */
        #global-confirm-modal { position: fixed; inset: 0; z-index: 20000; display: flex; align-items: center; justify-content: center; opacity: 0; visibility: hidden; transition: 0.2s; }
        #global-confirm-modal.active { opacity: 1; visibility: visible; }

        /* [CẬP NHẬT] Thêm backdrop-filter để làm mờ nội dung phía sau */
        .modal-backdrop {
            position: absolute; inset: 0;
            background: rgba(0,0,0,0.4);
            backdrop-filter: blur(5px); -webkit-backdrop-filter: blur(5px);
            transition: 0.3s; z-index: 1; pointer-events: auto;
        }

        .modal-box { position: relative; width: 300px; background: var(--modal-bg); backdrop-filter: blur(20px); border-radius: 14px; text-align: center; overflow: hidden; transform: scale(0.95); transition: 0.2s; box-shadow: 0 10px 40px rgba(0,0,0,0.3); border: 0.5px solid var(--modal-border); z-index: 2; }
        #global-confirm-modal.active .modal-box { transform: scale(1); }
        .modal-content-box { padding: 20px 16px 20px; }
        .modal-title { font-weight: 700; font-size: 1.1rem; margin-bottom: 6px; color: var(--modal-text); display: flex; align-items: center; justify-content: center; gap: 8px; }
        .modal-desc { font-size: 0.85rem; line-height: 1.4; color: var(--modal-text); opacity: 0.8; word-wrap: break-word; }
        .modal-actions { display: flex; border-top: 0.5px solid var(--modal-border); }
        .btn-modal { flex: 1; border: none; background: transparent; padding: 12px; font-size: 1.05rem; cursor: pointer; transition: 0.2s; border-right: 0.5px solid var(--modal-border); color: #007aff; font-weight: 400; }
        .btn-modal:last-child { border-right: none; }
        .btn-modal:active { background: rgba(127,127,127,0.15); }
        .modal-text-primary { color: #007aff !important; }
        .modal-text-danger { color: #ff3b30 !important; font-weight: 600; }
        .modal-text-success { color: #34c759 !important; font-weight: 600; }
        .modal-text-secondary { color: #6c757d !important; }
        body.dark-mode .modal-text-primary { color: #0a84ff !important; }
        body.dark-mode .modal-text-danger { color: #ff453a !important; }
    </style>
</head>
<body>

<div id="nav-backdrop"></div>
@include('client.partials.bubbles')
<div id="nav-popup">
    @include('client.partials.menu-popup')
    @include('client.partials.chat-popup')
    @include('client.partials.settings-popup')
</div>

<div id="main-wrapper">
    {{ $slot ?? '' }}
    @yield('content')
</div>

<div id="global-confirm-modal">
    <div class="modal-backdrop"></div>
    <div class="modal-box">
        <div class="modal-content-box">
            <div id="global-modal-title" class="modal-title"></div>
            <div id="global-modal-desc" class="modal-desc"></div>
        </div>
        <div id="global-modal-actions" class="modal-actions"></div>
    </div>
</div>

<script>
    // --- 1. THEME SETUP ---
    (function() {
        const savedTheme = localStorage.getItem('client_theme_preference');
        if (savedTheme === 'dark') document.body.classList.add('dark-mode');
    })();

    // --- 2. NEON MANAGER (3 MODES) ---
    const NeonManager = {
        currentMode: 1,
        timer: null,

        init: function() {
            const savedMode = localStorage.getItem('client_neon_mode');
            this.currentMode = savedMode !== null ? parseInt(savedMode) : 1;
            this.applyModeClass();

            if(this.currentMode === 2) {
                document.body.classList.add('neon-active');
            } else {
                document.body.classList.remove('neon-active');
            }
        },

        setMode: function(mode) {
            this.currentMode = parseInt(mode);
            localStorage.setItem('client_neon_mode', this.currentMode);
            this.applyModeClass();

            if (this.currentMode === 2) {
                this.wakeUp(true);
            } else if (this.currentMode === 0) {
                this.sleep(true);
            } else {
                this.sleep(true);
            }
        },

        applyModeClass: function() {
            document.body.classList.remove('neon-mode-0', 'neon-mode-1', 'neon-mode-2');
            document.body.classList.add(`neon-mode-${this.currentMode}`);
        },

        wakeUp: function(force = false) {
            if (this.currentMode === 0) {
                document.body.classList.remove('neon-active');
                return;
            }
            if (this.currentMode === 2 || force) {
                document.body.classList.add('neon-active');
                if(this.timer) clearTimeout(this.timer);
                return;
            }
            // Mode 1: Auto
            document.body.classList.add('neon-active');
            if(this.timer) clearTimeout(this.timer);
            this.timer = setTimeout(() => {
                this.sleep();
            }, 5000);
        },

        sleep: function(force = false) {
            if (this.currentMode === 2 && !force) return;
            document.body.classList.remove('neon-active');
        }
    };

    // [QUAN TRỌNG] Gán vào Window để các file con gọi được
    window.NeonManager = NeonManager;

    document.addEventListener('DOMContentLoaded', () => {
        NeonManager.init();

        const mainWrapper = document.getElementById('main-wrapper');
        const bubbleWrapper = document.getElementById('bubble-wrapper');
        if(mainWrapper && bubbleWrapper) {
            let lastScrollTop = 0;
            mainWrapper.addEventListener('scroll', () => {
                if (window.isSystemOpen || document.body.classList.contains('no-select')) return;
                const currentScroll = mainWrapper.scrollTop;
                if (currentScroll <= 50) {
                    bubbleWrapper.classList.remove('scroll-hidden');
                } else {
                    if (currentScroll > lastScrollTop) bubbleWrapper.classList.add('scroll-hidden');
                    else bubbleWrapper.classList.remove('scroll-hidden');
                }
                lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
            });
        }
    });

    // Helpers
    const closeGlobalModal = () => { document.getElementById('global-confirm-modal').classList.remove('active'); };

    function showDynamicModal(titleHtml, contentHtml, buttons = []) {
        const modal = document.getElementById('global-confirm-modal');
        document.getElementById('global-modal-title').innerHTML = titleHtml || '<i class="fa-solid fa-bell text-warning"></i> Thông báo';
        document.getElementById('global-modal-desc').innerHTML = contentHtml || '';
        const elActions = document.getElementById('global-modal-actions');
        elActions.innerHTML = '';

        if (!buttons.length) buttons = [{ text: 'Đóng', color: 'primary', action: { type: 'dismiss' } }];

        buttons.forEach(btnConfig => {
            const btn = document.createElement('button');
            const colorMap = { danger: 'modal-text-danger', success: 'modal-text-success', secondary: 'modal-text-secondary' };
            btn.className = `btn-modal ${colorMap[btnConfig.color] || 'modal-text-primary'}`;
            if (btnConfig.isBold) btn.style.fontWeight = "600";
            btn.innerHTML = btnConfig.text;
            btn.onclick = () => {
                if (btnConfig.action?.type === 'url') window.location.href = btnConfig.action.value;
                else if (btnConfig.action?.type === 'livewire') { Livewire.dispatch(btnConfig.action.value, btnConfig.action.params || {}); closeGlobalModal(); }
                else if (btnConfig.action?.type === 'callback') { btnConfig.action.value(); if (!btnConfig.action.preventClose) closeGlobalModal(); }
                else closeGlobalModal();
            };
            elActions.appendChild(btn);
        });
        modal.classList.add('active');
    }

    window.showAlert = (title, desc, btnText = 'Đóng', btnColor = 'primary', callback = null) => showDynamicModal(`<i class="fa-solid fa-bell text-warning"></i> ${title}`, desc, [{ text: btnText, color: btnColor, isBold: btnColor !== 'primary', action: { type: 'callback', value: callback } }]);
    window.showConfirm = (title, desc, cancelText, confirmText, onConfirm) => {
        if (typeof cancelText === 'function') { onConfirm = cancelText; cancelText = 'Hủy'; confirmText = 'Đồng ý'; }
        showDynamicModal(`<i class="fa-solid fa-circle-question text-danger"></i> ${title}`, desc, [{ text: cancelText || 'Hủy', color: 'secondary', action: { type: 'dismiss' } }, { text: confirmText || 'Đồng ý', color: 'danger', isBold: true, action: { type: 'callback', value: onConfirm } }]);
    };
</script>

{{-- === PHẦN SCRIPT PUSHER (ĐƯỢC BỔ SUNG ĐỂ NHẬN THÔNG BÁO) === --}}
<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
<script>
    var pusher = new Pusher('bbd581278169e135dc72', { cluster: 'ap1' });
    var channel = pusher.subscribe('notifications');

    channel.bind('system.message', function(data) {
        const noti = data.notification;
        if (!noti) return;

        // Tự động thêm icon dựa trên loại thông báo
        let iconHtml = '<i class="fa-solid fa-bell text-warning"></i>';
        if (noti.type === 'success') iconHtml = '<i class="fa-solid fa-circle-check text-success"></i>';
        else if (noti.type === 'error') iconHtml = '<i class="fa-solid fa-circle-exclamation text-danger"></i>';
        else if (noti.type === 'warning') iconHtml = '<i class="fa-solid fa-triangle-exclamation text-warning"></i>';

        const fullTitle = `${iconHtml} ${noti.title}`;
        showDynamicModal(fullTitle, noti.content, noti.buttons);
    });
</script>

@livewireScripts
</body>
</html>
