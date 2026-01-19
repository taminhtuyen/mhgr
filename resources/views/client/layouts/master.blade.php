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
            --input-darker: #f1f5f9;
            --transDur: 0.3s;

            /* Modal Colors Light */
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
            --input-darker: #0b1120;

            /* Modal Colors Dark */
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

        /* ====== GLOBAL CONFIRM MODAL (iOS STYLE - DYNAMIC) ====== */
        #global-confirm-modal { position: fixed; inset: 0; z-index: 20000; display: flex; align-items: center; justify-content: center; opacity: 0; visibility: hidden; transition: 0.2s; }
        #global-confirm-modal.active { opacity: 1; visibility: visible; }

        .modal-backdrop {
            position: absolute; inset: 0;
            background: rgba(0,0,0,0.4);
            transition: 0.3s;
            z-index: 1;
            pointer-events: auto;
        }

        .modal-box {
            position: relative; width: 300px;
            background: var(--modal-bg);
            backdrop-filter: blur(20px) saturate(180%); -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-radius: 14px; text-align: center; overflow: hidden;
            transform: scale(0.95); transition: 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            border: 0.5px solid var(--modal-border);
            z-index: 2;
        }

        #global-confirm-modal.active .modal-box { transform: scale(1); }

        .modal-content-box { padding: 20px 16px 20px; }
        /* CẬP NHẬT: Sử dụng rem cho tiêu đề và mô tả để hỗ trợ co giãn cỡ chữ hệ thống */
        .modal-title { font-weight: 700; font-size: 1.1rem; margin-bottom: 6px; color: var(--modal-text); }
        .modal-desc { font-size: 0.85rem; line-height: 1.4; color: var(--modal-text); opacity: 0.8; word-wrap: break-word; }

        /* --- DYNAMIC ACTIONS AREA --- */
        .modal-actions { display: flex; border-top: 0.5px solid var(--modal-border); }

        .btn-modal {
            flex: 1; border: none; background: transparent; padding: 12px;
            /* CẬP NHẬT: Sử dụng rem cho cỡ chữ của nút bấm để hỗ trợ co giãn */
            font-size: 1.05rem; cursor: pointer; transition: 0.2s;
            border-right: 0.5px solid var(--modal-border);
            color: #007aff; /* Default iOS Blue */
            font-weight: 400;
        }
        .btn-modal:last-child { border-right: none; }
        .btn-modal:active { background: rgba(127,127,127,0.15); }

        /* --- COLOR VARIANTS (iOS Standard) --- */
        .modal-text-primary { color: #007aff !important; font-weight: 400; }
        .modal-text-danger { color: #ff3b30 !important; font-weight: 600; }
        .modal-text-success { color: #34c759 !important; font-weight: 600; }
        .modal-text-bold { font-weight: 600 !important; }

        /* Dark Mode Adaptation */
        body.dark-mode .modal-text-primary { color: #0a84ff !important; }
        body.dark-mode .modal-text-danger { color: #ff453a !important; }
        body.dark-mode .modal-text-success { color: #30d158 !important; }
    </style>
</head>
<body>

{{-- SYSTEM POPUP & BUBBLES --}}
<div id="nav-backdrop"></div>

@include('client.partials.bubbles')

<div id="nav-popup">
    @include('client.partials.menu-popup')
    @include('client.partials.chat-popup')
    {{-- MỚI: Thêm file cài đặt vào đây --}}
    @include('client.partials.settings-popup')
</div>

{{-- MAIN CONTENT --}}
<div id="main-wrapper">
    {{ $slot ?? '' }}
    @yield('content')
</div>

{{-- GLOBAL MODAL DYNAMIC --}}
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

    // --- 2. SCROLL LOGIC ---
    document.addEventListener('DOMContentLoaded', () => {
        const mainWrapper = document.getElementById('main-wrapper');
        const bubbleWrapper = document.getElementById('bubble-wrapper');
        if(mainWrapper && bubbleWrapper) {
            let lastScrollTop = 0;
            const scrollThreshold = 50;
            mainWrapper.addEventListener('scroll', () => {
                if (window.isSystemOpen || document.body.classList.contains('no-select')) return;
                const currentScroll = mainWrapper.scrollTop;
                if (currentScroll <= scrollThreshold) {
                    bubbleWrapper.classList.remove('scroll-hidden');
                } else {
                    if (currentScroll > lastScrollTop) bubbleWrapper.classList.add('scroll-hidden');
                    else bubbleWrapper.classList.remove('scroll-hidden');
                }
                lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
            });
        }
    });

    // --- 3. HỆ THỐNG POPUP THÔNG MINH (CORE) ---

    const closeGlobalModal = () => {
        document.getElementById('global-confirm-modal').classList.remove('active');
    };

    /**
     * Hàm hiển thị Modal tuỳ biến cao cấp
     */
    function showCustomModal(title, desc, buttons = []) {
        const modal = document.getElementById('global-confirm-modal');
        const elTitle = document.getElementById('global-modal-title');
        const elDesc = document.getElementById('global-modal-desc');
        const elActions = document.getElementById('global-modal-actions');

        elTitle.innerHTML = title || 'Thông báo';
        elDesc.innerHTML = desc || '';
        elActions.innerHTML = '';

        buttons.forEach(btn => {
            const button = document.createElement('button');
            button.className = 'btn-modal ' + (btn.class || 'modal-text-primary');
            button.innerHTML = btn.text || 'Nút';

            button.onclick = () => {
                if (typeof btn.onClick === 'function') {
                    btn.onClick();
                }
                if (!btn.preventClose) {
                    closeGlobalModal();
                }
            };
            elActions.appendChild(button);
        });

        modal.classList.add('active');
    }

    // --- 4. SHORTCUT HELPERS ---

    window.showAlert = function(title, desc, btnText = 'Đóng', btnColor = 'primary', callback = null) {
        const btnClass = `modal-text-${btnColor}`;
        showCustomModal(title, desc, [
            {
                text: btnText,
                class: btnClass + (btnColor !== 'primary' ? ' modal-text-bold' : ''),
                onClick: callback
            }
        ]);
    };

    window.showConfirm = function(title, desc, arg3, arg4, arg5) {
        let cancelText = 'Hủy';
        let confirmText = 'Đồng ý';
        let onConfirm = null;
        let onCancel = null;
        let confirmColor = 'danger';
        let cancelColor = 'primary';

        if (typeof arg3 === 'function') {
            onConfirm = arg3;
            const options = arg4 || {};

            if(options.cancelText) cancelText = options.cancelText;
            if(options.confirmText) confirmText = options.confirmText;
            if(options.confirmColor) confirmColor = options.confirmColor;
            if(options.cancelColor) cancelColor = options.cancelColor;

            if(options.onCancel && typeof options.onCancel === 'function') {
                onCancel = options.onCancel;
            }
        } else {
            cancelText = arg3 || 'Hủy';
            confirmText = arg4 || 'Đồng ý';
            onConfirm = arg5;
        }

        showCustomModal(title, desc, [
            {
                text: cancelText,
                class: `modal-text-${cancelColor}`,
                onClick: onCancel
            },
            {
                text: confirmText,
                class: `modal-text-${confirmColor}`,
                onClick: onConfirm
            }
        ]);
    };
</script>

{{-- --- REAL-TIME NOTIFICATION SYSTEM (PUSHER) --- --}}
<script src="{{ asset('js/pusher.min.js') }}"></script>
<script>
    var pusher = new Pusher('bbd581278169e135dc72', {
        cluster: 'ap1'
    });
    var channel = pusher.subscribe('notifications');
    channel.bind('system.message', function(data) {
        let btnColor = 'primary';
        if (data.type === 'error') btnColor = 'danger';
        else if (data.type === 'success') btnColor = 'success';

        if (typeof window.showAlert === 'function') {
            window.showAlert(
                '<i class="fa-solid fa-bell text-warning"></i> THÔNG BÁO MỚI',
                data.message,
                'Đã xem',
                btnColor
            );
        } else {
            alert('Thông báo: ' + data.message);
        }
    });
</script>

@livewireScripts
</body>
</html>
