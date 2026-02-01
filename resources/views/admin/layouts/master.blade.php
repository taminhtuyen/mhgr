<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    @livewireStyles
    @stack('styles')

    <style>
        /* --- GLOBAL VARIABLES --- */
        :root {
            /* Light Mode */
            --bg-body: #f8fafc;
            --text-color: #0f172a;
            --text-muted: #64748b;
            --popup-bg: rgba(255, 255, 255, 0.95);
            --popup-border: rgba(0, 0, 0, 0.08);
            --popup-shadow: 0 10px 40px -10px rgba(0,0,0,0.1);
            --link-hover-bg: #f1f5f9;
            --primary: #0ea5e9;
            --scrollbar-thumb: #cbd5e1;

            /* Switch Colors */
            --switch-gray: #9ca3af;
            --switch-green: #10b981;
            --switch-knob: #ffffff;

            /* Modal Colors */
            --modal-bg: rgba(255, 255, 255, 0.9);
            --modal-text: #000;
            --modal-border: rgba(60, 60, 67, 0.29);
        }

        body.dark-mode {
            /* Dark Mode */
            --bg-body: #020617;
            --text-color: #f8fafc;
            --text-muted: #94a3b8;
            --popup-bg: rgba(15, 23, 42, 0.95);
            --popup-border: rgba(255, 255, 255, 0.1);
            --popup-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
            --link-hover-bg: rgba(255, 255, 255, 0.08);
            --primary: #38bdf8;
            --scrollbar-thumb: #334155;
            --switch-gray: #4b5563;
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

        .admin-container { width: 100%; padding: 15px; margin: 0 auto; }
        @media (min-width: 998px) { .admin-container { padding: 30px; max-width: 1400px; } }

        /* Utility */
        .glass-effect { backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
        .cursor-pointer { cursor: pointer !important; }

        /* Dark Mode Overrides */
        body.dark-mode .text-dark { color: #f1f5f9 !important; }
        body.dark-mode .text-primary { color: #38bdf8 !important; }
        body.dark-mode .text-secondary { color: #cbd5e1 !important; }
        body.dark-mode .form-control { background-color: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1); color: #fff; }
        body.dark-mode .form-control:focus { background-color: rgba(255,255,255,0.08); border-color: var(--primary); color: #fff; box-shadow: none; }

        /* Component Tri-State Switch */
        .tri-state-toggle { position: relative; display: inline-flex; align-items: center; cursor: pointer; width: 3rem; height: 3rem; user-select: none; }
        .tri-state-toggle .toggle-bg { width: 3rem; height: 1.6rem; border-radius: 9999px; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); position: absolute; top: 50%; transform: translateY(-50%); left: 0; right: 0; background-color: var(--switch-gray); }
        .tri-state-toggle .toggle-knob { width: 2.2rem; height: 2.2rem; background-color: var(--switch-knob); border-radius: 9999px; position: absolute; top: 50%; left: 0; transform: translateY(-50%) rotate(-180deg); box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); display: flex; justify-content: center; align-items: center; font-size: 0.75rem; font-weight: 800; color: var(--switch-gray); transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1); z-index: 2; }
        .tri-state-toggle[data-state="0"] .toggle-bg { background-color: var(--switch-gray); opacity: 0.5; }
        .tri-state-toggle[data-state="0"] .toggle-knob { left: 0; transform: translateY(-50%) rotate(-180deg); color: #9ca3af; }
        .tri-state-toggle[data-state="0"] .toggle-knob::after { content: ''; width: 8px; height: 8px; background: #d1d5db; border-radius: 50%; }
        .tri-state-toggle[data-state="1"] .toggle-bg { background-color: var(--switch-green); opacity: 1; }
        .tri-state-toggle[data-state="1"] .toggle-knob { left: 0.8rem; transform: translateY(-50%) rotate(0deg); color: var(--switch-green); }
        .tri-state-toggle[data-state="1"] .toggle-knob::after { content: '5s'; }
        .tri-state-toggle[data-state="2"] .toggle-bg { background-color: var(--switch-green); opacity: 1; }
        .tri-state-toggle[data-state="2"] .toggle-knob { left: 0.8rem; transform: translateY(-50%) rotate(0deg); color: var(--switch-green); }
        .tri-state-toggle[data-state="2"] .toggle-knob::after { content: '✔'; font-size: 1rem; }
        .tri-state-toggle:hover .toggle-knob { transform: translateY(-50%) rotate(0deg) scale(0.85) !important; }
        .tri-state-toggle[data-state="0"]:hover .toggle-knob { transform: translateY(-50%) rotate(-180deg) scale(0.85) !important; }

        /* Global Modal Styles */
        #global-confirm-modal { position: fixed; inset: 0; z-index: 20000; display: flex; align-items: center; justify-content: center; opacity: 0; visibility: hidden; transition: 0.2s; }
        #global-confirm-modal.active { opacity: 1; visibility: visible; }
        .modal-backdrop { position: absolute; inset: 0; background: rgba(0,0,0,0.4); transition: 0.3s; z-index: 1; pointer-events: auto; }
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

<div id="main-wrapper">
    <div class="admin-container">
        @yield('content')
    </div>
</div>

<div id="nav-backdrop"></div>
@include('admin.partials.bubbles')
<div id="nav-popup">
    @include('admin.partials.menu-popup')
    @include('admin.partials.chat-popup')
    @include('admin.partials.settings-popup')
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
    // --- 1. NEON MANAGER SYSTEM ---
    const NeonManager = {
        timer: null,
        mode: 0, // 0: Off, 1: 5s, 2: Always On

        init() {
            this.mode = parseInt(localStorage.getItem('admin_neon_mode') || '2');
            this.applyMode();
        },

        setMode(newMode) {
            this.mode = newMode;
            localStorage.setItem('admin_neon_mode', newMode);
            this.applyMode();
        },

        applyMode() {
            const body = document.body;
            if (this.timer) clearTimeout(this.timer);

            if (this.mode === 0) {
                body.classList.remove('neon-active');
            } else if (this.mode === 2) {
                body.classList.add('neon-active');
            }
        },

        // [QUAN TRỌNG] Bật đèn (khi hover/click)
        wakeUp() {
            if (this.mode !== 1) return; // Chỉ áp dụng mode 5s

            document.body.classList.add('neon-active');
            if (this.timer) clearTimeout(this.timer);

            // Auto tắt sau 5s nếu không có tương tác gì thêm
            this.timer = setTimeout(() => {
                document.body.classList.remove('neon-active');
            }, 5000);
        },

        // [QUAN TRỌNG] Tắt đèn (khi rời chuột)
        sleep() {
            if (this.mode !== 1) return;

            // Xóa ngay class active để CSS transition (2s) hoạt động
            if (this.timer) clearTimeout(this.timer);
            document.body.classList.remove('neon-active');
        }
    };

    // --- 2. THEME SETUP ---
    (function() {
        const savedTheme = localStorage.getItem('admin_theme_preference');
        if (savedTheme === 'dark') document.body.classList.add('dark-mode');
        NeonManager.init();
    })();

    // --- 3. SCROLL & MODAL ---
    document.addEventListener('DOMContentLoaded', () => {
        const mainWrapper = document.getElementById('main-wrapper');
        const bubbleWrapper = document.getElementById('bubble-wrapper');
        if(mainWrapper && bubbleWrapper) {
            let lastScrollTop = 0;
            mainWrapper.addEventListener('scroll', () => {
                if (window.isSystemOpen || document.body.classList.contains('no-select')) return;
                const currentScroll = mainWrapper.scrollTop;
                bubbleWrapper.classList.toggle('scroll-hidden', currentScroll > 50 && currentScroll > lastScrollTop);
                lastScrollTop = Math.max(0, currentScroll);
            });
        }
    });

    const closeGlobalModal = () => document.getElementById('global-confirm-modal').classList.remove('active');

    function showDynamicModal(titleHtml, contentHtml, buttons = []) {
        const modal = document.getElementById('global-confirm-modal');
        document.getElementById('global-modal-title').innerHTML = titleHtml || '<i class="fa-solid fa-bell text-warning"></i> THÔNG BÁO';
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

    window.NeonManager = NeonManager;
</script>

{{-- PUSHER --- --}}
<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
<script>
    var pusher = new Pusher('bbd581278169e135dc72', { cluster: 'ap1' });
    var channel = pusher.subscribe('notifications');
    channel.bind('system.message', function(data) {
        const noti = data.notification; if (!noti) return;
        const iconMap = { success: 'circle-check text-success', error: 'circle-exclamation text-danger', warning: 'triangle-exclamation text-warning' };
        showDynamicModal(`<i class="fa-solid fa-${iconMap[noti.type] || 'bell text-warning'}"></i> ${noti.title}`, noti.content, noti.buttons);
    });
</script>

@livewireScripts
</body>
</html>
