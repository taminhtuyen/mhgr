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
            --modal-btn-cancel: #007aff;
            --modal-btn-confirm: #ff3b30;
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
            --modal-btn-cancel: #0a84ff;
            --modal-btn-confirm: #ff453a;
        }

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
            z-index: 1; /* Nằm dưới Box */
        }

        .modal-box {
            position: relative; width: 300px;
            background: var(--modal-bg);
            backdrop-filter: blur(20px) saturate(180%); -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-radius: 14px; text-align: center; overflow: hidden;
            transform: scale(0.95); transition: 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            border: 0.5px solid var(--modal-border);
            z-index: 2; /* Nổi lên trên Backdrop */
        }

        #global-confirm-modal.active .modal-box { transform: scale(1); }

        .modal-content-box { padding: 20px 16px 20px; }
        /* Title & Desc support HTML */
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

{{-- SYSTEM POPUP & BUBBLES --}}
<div id="nav-backdrop"></div>

@include('client.partials.bubbles')

<div id="nav-popup">
    @include('client.partials.menu-popup')
    @include('client.partials.chat-popup')
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
        <div class="modal-actions">
            <button class="btn-modal btn-cancel" id="btn-global-cancel"></button>
            <button class="btn-modal btn-confirm" id="btn-global-confirm"></button>
        </div>
    </div>
</div>

<script>
    // --- 1. KHỞI TẠO THEME NGAY LẬP TỨC ---
    (function() {
        const savedTheme = localStorage.getItem('client_theme_preference');
        if (savedTheme === 'dark') {
            document.body.classList.add('dark-mode');
        }
    })();

    // --- 2. LOGIC SCROLL ẨN/HIỆN BUBBLE ---
    document.addEventListener('DOMContentLoaded', () => {
        const mainWrapper = document.getElementById('main-wrapper');
        const bubbleWrapper = document.getElementById('bubble-wrapper');

        if(mainWrapper && bubbleWrapper) {
            let lastScrollTop = 0;
            const scrollThreshold = 50; // 50px vùng an toàn trên top

            mainWrapper.addEventListener('scroll', () => {
                // Nếu menu đang mở hoặc đang drag -> không xử lý ẩn hiện
                if (window.isSystemOpen || document.body.classList.contains('no-select')) return;

                const currentScroll = mainWrapper.scrollTop;

                // Logic: Chỉ bắt đầu ẩn hiện khi đã cuộn qua threshold
                if (currentScroll <= scrollThreshold) {
                    // Đang ở đỉnh trang -> Luôn hiện
                    bubbleWrapper.classList.remove('scroll-hidden');
                } else {
                    // Đã cuộn xuống sâu
                    if (currentScroll > lastScrollTop) {
                        // Đang cuộn xuống (scroll down) -> Ẩn
                        bubbleWrapper.classList.add('scroll-hidden');
                    } else {
                        // Đang cuộn lên (scroll up) -> Hiện
                        bubbleWrapper.classList.remove('scroll-hidden');
                    }
                }
                lastScrollTop = currentScroll <= 0 ? 0 : currentScroll; // Avoid negative
            });
        }
    });

    // --- 3. HỆ THỐNG POPUP TOÀN CỤC (CORE) ---
    function showGlobalModal(type, titleHtml, descHtml, cancelText, confirmText, onConfirm) {
        const modal = document.getElementById('global-confirm-modal');
        const elTitle = document.getElementById('global-modal-title');
        const elDesc = document.getElementById('global-modal-desc');
        const btnCancel = document.getElementById('btn-global-cancel');
        const btnConfirm = document.getElementById('btn-global-confirm');

        // Reset trạng thái hiển thị
        btnCancel.style.display = 'block';
        btnConfirm.style.width = 'auto';

        // Gán nội dung
        elTitle.innerHTML = titleHtml || 'Thông báo';
        elDesc.innerHTML = descHtml || '';
        btnCancel.innerText = cancelText || 'Hủy';
        btnConfirm.innerText = confirmText || 'Đồng ý';

        // Nếu là Alert: Ẩn nút Hủy
        if (type === 'alert') {
            btnCancel.style.display = 'none';
        }

        // Hiển thị
        modal.classList.add('active');

        // Hàm đóng
        const closeModal = () => { modal.classList.remove('active'); };

        // Xử lý sự kiện (Gán đè để tránh lặp)
        btnCancel.onclick = closeModal;

        modal.onclick = (e) => {
            if(e.target === modal || e.target.classList.contains('modal-backdrop')) {
                closeModal();
            }
        };

        btnConfirm.onclick = () => {
            if (typeof onConfirm === 'function') {
                onConfirm();
            }
            closeModal();
        };
    }

    // --- 4. PUBLIC API ---

    /**
     * Popup Xác nhận (2 nút)
     */
    window.showConfirm = function(title, desc, txtCancel, txtConfirm, callback) {
        showGlobalModal('confirm', title, desc, txtCancel, txtConfirm, callback);
    };

    /**
     * Popup Thông báo (1 nút)
     */
    window.showAlert = function(title, desc, txtBtn = 'Đóng', callback = null) {
        showGlobalModal('alert', title, desc, null, txtBtn, callback);
    };
</script>

@livewireScripts
</body>
</html>
