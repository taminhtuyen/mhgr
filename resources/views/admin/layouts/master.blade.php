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
            --link-hover-text: #0ea5e9;
            --primary: #0ea5e9;
            --scrollbar-thumb: #cbd5e1;
            --input-darker: #f1f5f9;
            --transDur: 0.3s;

            /* Modal Colors Light */
            --modal-bg: rgba(255, 255, 255, 0.9);
            --modal-text: #000;
            --modal-border: rgba(60, 60, 67, 0.29);
            --modal-btn-cancel: #007aff;
            --modal-btn-confirm: #ff3b30;
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
            --link-hover-text: #38bdf8;
            --primary: #38bdf8;
            --scrollbar-thumb: #334155;
            --input-darker: #0b1120;

            /* Modal Colors Dark */
            --modal-bg: rgba(30, 30, 30, 0.9);
            --modal-text: #fff;
            --modal-border: rgba(84, 84, 88, 0.65);
            --modal-btn-cancel: #0a84ff;
            --modal-btn-confirm: #ff453a;
        }

        /* UPDATED: Cấu trúc cuộn cố định (Fixed Body, Scroll Wrapper) */
        html, body { height: 100%; margin: 0; padding: 0; overflow: hidden; font-family: 'Segoe UI', sans-serif; transition: background-color 0.3s, color 0.3s; background-color: var(--bg-body); color: var(--text-color); }
        body.no-select { user-select: none; -webkit-user-select: none; }

        /* UPDATED: Main Wrapper là khung cuộn chính */
        #main-wrapper { width: 100%; height: 100%; overflow-y: auto; overflow-x: hidden; position: relative; z-index: 1; padding-bottom: 100px; -webkit-overflow-scrolling: touch; scroll-behavior: smooth; }
        #main-wrapper::-webkit-scrollbar { width: 8px; }
        #main-wrapper::-webkit-scrollbar-track { background: transparent; }
        #main-wrapper::-webkit-scrollbar-thumb { background-color: var(--scrollbar-thumb); border-radius: 10px; }

        .admin-container { width: 100%; padding: 15px; margin: 0 auto; }
        @media (min-width: 998px) { .admin-container { padding: 30px; max-width: 1400px; } }

        /* Utility */
        .glass-effect { backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
        .cursor-pointer { cursor: pointer !important; }

        /* Dark Mode overrides common */
        body.dark-mode .text-dark { color: #f1f5f9 !important; }
        body.dark-mode .text-primary { color: #38bdf8 !important; }
        body.dark-mode .text-secondary { color: #cbd5e1 !important; }
        body.dark-mode .border-bottom { border-color: var(--popup-border) !important; }
        body.dark-mode .form-control { background-color: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1); color: #fff; }
        body.dark-mode .form-control:focus { background-color: rgba(255,255,255,0.08); border-color: var(--primary); color: #fff; box-shadow: none; }

        /* ====== GLOBAL CONFIRM MODAL (iOS STYLE - DYNAMIC) ====== */
        #global-confirm-modal { position: fixed; inset: 0; z-index: 20000; display: flex; align-items: center; justify-content: center; opacity: 0; visibility: hidden; transition: 0.2s; }
        #global-confirm-modal.active { opacity: 1; visibility: visible; }

        .modal-backdrop {
            position: absolute; inset: 0;
            background: rgba(0,0,0,0.4);
            transition: 0.3s;
            z-index: 1;
            /* Ngăn chặn sự kiện chuột xuyên qua nhưng không đóng */
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
        .modal-title { font-weight: 700; font-size: 17px; margin-bottom: 6px; color: var(--modal-text); }
        .modal-desc { font-size: 13px; line-height: 1.4; color: var(--modal-text); opacity: 0.8; word-wrap: break-word; }

        .modal-actions { display: flex; border-top: 0.5px solid var(--modal-border); }

        .btn-modal {
            flex: 1; border: none; background: transparent; padding: 12px;
            font-size: 17px; cursor: pointer; transition: 0.2s;
        }
        .btn-modal:active { background: rgba(127,127,127,0.15); }

        .btn-cancel { color: var(--modal-btn-cancel); border-right: 0.5px solid var(--modal-border); font-weight: 400; }
        .btn-confirm { color: var(--modal-btn-confirm); font-weight: 600; }
    </style>
</head>
<body>

<div id="main-wrapper">
    <div class="admin-container">
        @yield('content')
    </div>
</div>

{{-- SYSTEM POPUP & BUBBLES --}}
<div id="nav-backdrop"></div>

@include('admin.partials.bubbles')

<div id="nav-popup">
    @include('admin.partials.menu-popup')
    @include('admin.partials.chat-popup')
</div>

{{-- GLOBAL MODAL DYNAMIC --}}
<div id="global-confirm-modal">
    <div class="modal-backdrop"></div>
    <div class="modal-box">
        <div class="modal-content-box">
            <div id="global-modal-title" class="modal-title"></div>
            <div id="global-modal-desc" class="modal-desc"></div>
        </div>
        <div class="modal-actions">
            <button class="btn-modal btn-cancel" id="btn-global-cancel"></button>
            <button class="btn-modal btn-confirm" id="btn-global-confirm"></button>
        </div>
    </div>
</div>

<script>
    // --- 1. KHỞI TẠO THEME ---
    (function() {
        const savedTheme = localStorage.getItem('admin_theme_preference');
        if (savedTheme === 'dark') {
            document.body.classList.add('dark-mode');
        }
    })();

    // --- 2. LOGIC SCROLL ẨN/HIỆN BUBBLE (FIXED) ---
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
                    if (currentScroll > lastScrollTop) {
                        bubbleWrapper.classList.add('scroll-hidden'); // Cuộn xuống -> Ẩn
                    } else {
                        bubbleWrapper.classList.remove('scroll-hidden'); // Cuộn lên -> Hiện
                    }
                }
                lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
            });
        }
    });

    // --- 3. HỆ THỐNG POPUP TOÀN CỤC ---
    function showGlobalModal(type, titleHtml, descHtml, cancelText, confirmText, onConfirm) {
        const modal = document.getElementById('global-confirm-modal');
        const elTitle = document.getElementById('global-modal-title');
        const elDesc = document.getElementById('global-modal-desc');
        const btnCancel = document.getElementById('btn-global-cancel');
        const btnConfirm = document.getElementById('btn-global-confirm');

        btnCancel.style.display = 'block';
        btnConfirm.style.width = 'auto';

        elTitle.innerHTML = titleHtml || 'Thông báo';
        elDesc.innerHTML = descHtml || '';
        btnCancel.innerText = cancelText || 'Hủy';
        btnConfirm.innerText = confirmText || 'Đồng ý';

        if (type === 'alert') {
            btnCancel.style.display = 'none';
        }

        modal.classList.add('active');

        const closeModal = () => { modal.classList.remove('active'); };

        // Chỉ đóng khi nhấn nút, KHÔNG đóng khi nhấn background
        btnCancel.onclick = closeModal;

        btnConfirm.onclick = () => {
            if (typeof onConfirm === 'function') {
                onConfirm();
            }
            closeModal();
        };
    }

    window.showConfirm = function(title, desc, txtCancel, txtConfirm, callback) {
        showGlobalModal('confirm', title, desc, txtCancel, txtConfirm, callback);
    };

    window.showAlert = function(title, desc, txtBtn = 'Đóng', callback = null) {
        showGlobalModal('alert', title, desc, null, txtBtn, callback);
    };
</script>

{{-- --- REAL-TIME NOTIFICATION SYSTEM (PUSHER) --- --}}
<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
<script>
    var pusher = new Pusher('bbd581278169e135dc72', {
        cluster: 'ap1'
    });
    var channel = pusher.subscribe('notifications');
    channel.bind('system.message', function(data) {
        if (typeof window.showAlert === 'function') {
            window.showAlert(
                '<i class="fa-solid fa-bell text-warning"></i> THÔNG BÁO MỚI',
                data.message,
                'Đã xem'
            );
        } else {
            alert('Thông báo: ' + data.message);
        }
    });
</script>

@livewireScripts
</body>
</html>
