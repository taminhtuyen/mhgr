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

        /* CẬP NHẬT: Title hỗ trợ Flex để căn chỉnh Icon đẹp hơn */
        .modal-title {
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 6px;
            color: var(--modal-text);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .modal-desc { font-size: 0.85rem; line-height: 1.4; color: var(--modal-text); opacity: 0.8; word-wrap: break-word; }

        /* Hỗ trợ ảnh trong nội dung */
        .modal-desc img { max-width: 100%; border-radius: 6px; margin-top: 8px; }

        /* --- DYNAMIC ACTIONS AREA --- */
        .modal-actions { display: flex; border-top: 0.5px solid var(--modal-border); }

        .btn-modal {
            flex: 1; border: none; background: transparent; padding: 12px;
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
        /* Thêm màu Secondary nếu cần */
        .modal-text-secondary { color: #6c757d !important; font-weight: 400; }
        .modal-text-bold { font-weight: 600 !important; }

        /* Dark Mode Adaptation */
        body.dark-mode .modal-text-primary { color: #0a84ff !important; }
        body.dark-mode .modal-text-danger { color: #ff453a !important; }
        body.dark-mode .modal-text-success { color: #30d158 !important; }
        body.dark-mode .modal-text-secondary { color: #98989d !important; }
    </style>
</head>
<body>

{{-- SYSTEM POPUP & BUBBLES --}}
<div id="nav-backdrop"></div>

@include('client.partials.bubbles')

<div id="nav-popup">
    @include('client.partials.menu-popup')
    @include('client.partials.chat-popup')
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

{{-- --- SCRIPT XỬ LÝ (UPDATED) --- --}}
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

    // --- 3. HỆ THỐNG POPUP THÔNG MINH (CORE LOGIC ĐỒNG BỘ VỚI ADMIN) ---

    const closeGlobalModal = () => {
        document.getElementById('global-confirm-modal').classList.remove('active');
    };

    /**
     * Hàm hiển thị Modal đa năng (Advanced)
     * Thay thế showCustomModal cũ bằng logic xử lý thông minh hơn
     * @param {string} titleHtml - Tiêu đề (có thể chứa HTML Icon)
     * @param {string} contentHtml - Nội dung HTML
     * @param {Array} buttons - Mảng cấu hình nút
     */
    function showDynamicModal(titleHtml, contentHtml, buttons = []) {
        const modal = document.getElementById('global-confirm-modal');
        const elTitle = document.getElementById('global-modal-title');
        const elDesc = document.getElementById('global-modal-desc');
        const elActions = document.getElementById('global-modal-actions');

        // Mặc định tiêu đề nếu null
        if (!titleHtml) {
            titleHtml = '<i class="fa-solid fa-bell text-warning"></i> Thông báo';
        }

        elTitle.innerHTML = titleHtml;
        elDesc.innerHTML = contentHtml || '';
        elActions.innerHTML = '';

        // Fallback Buttons
        if (!buttons || buttons.length === 0) {
            buttons = [{ text: 'Đóng', color: 'primary', action: { type: 'dismiss' } }];
        }

        buttons.forEach(btnConfig => {
            const button = document.createElement('button');

            // Map màu sắc iOS chuẩn
            let colorClass = 'modal-text-primary';
            if (btnConfig.color === 'danger') colorClass = 'modal-text-danger';
            if (btnConfig.color === 'success') colorClass = 'modal-text-success';
            if (btnConfig.color === 'secondary') colorClass = 'modal-text-secondary';

            // Logic CSS Class
            button.className = `btn-modal ${colorClass}`;
            if (btnConfig.isBold) button.style.fontWeight = "600";

            button.innerHTML = btnConfig.text || 'Nút';

            // Xử lý Sự kiện Click
            button.onclick = () => {
                const action = btnConfig.action || {};

                // 1. Chuyển trang (URL Redirect)
                if (action.type === 'url' && action.value) {
                    window.location.href = action.value;
                }
                // 2. Gọi Livewire (Dispatch Event)
                else if (action.type === 'livewire' && action.value) {
                    if (typeof Livewire !== 'undefined') {
                        Livewire.dispatch(action.value, action.params || {});
                    }
                    closeGlobalModal();
                }
                // 3. Callback Javascript Nội bộ (Dùng cho code cũ)
                else if (action.type === 'callback' && typeof action.value === 'function') {
                    action.value();
                    if (!action.preventClose) closeGlobalModal();
                }
                // 4. Mặc định: Đóng modal
                else {
                    closeGlobalModal();
                }
            };
            elActions.appendChild(button);
        });

        modal.classList.add('active');
    }

    // --- 4. SHORTCUT HELPERS (Tương thích code cũ) ---
    // Giữ lại để code Client cũ không bị lỗi, nhưng mapping sang hàm showDynamicModal mới

    window.showAlert = function(title, desc, btnText = 'Đóng', btnColor = 'primary', callback = null) {
        // Tự động thêm icon vào title cũ để đồng bộ giao diện mới
        const icon = '<i class="fa-solid fa-bell text-warning"></i>';
        showDynamicModal(`${icon} ${title}`, desc, [{
            text: btnText,
            color: btnColor,
            isBold: btnColor !== 'primary', // Logic cũ: Nếu không phải primary thì in đậm
            action: { type: 'callback', value: callback }
        }]);
    };

    window.showConfirm = function(title, desc, cancelText, confirmText, onConfirm) {
        let _onConfirm = onConfirm;
        let _cancelText = cancelText || 'Hủy';
        let _confirmText = confirmText || 'Đồng ý';

        // Xử lý overload tham số linh hoạt của hàm cũ
        if (typeof cancelText === 'function') {
            _onConfirm = cancelText;
            _cancelText = 'Hủy';
            _confirmText = 'Đồng ý';
        }

        const icon = '<i class="fa-solid fa-circle-question text-danger"></i>';

        showDynamicModal(`${icon} ${title}`, desc, [
            { text: _cancelText, color: 'primary', action: { type: 'dismiss' } }, // Nút Hủy màu xanh (iOS)
            { text: _confirmText, color: 'danger', isBold: true, action: { type: 'callback', value: _onConfirm } } // Nút Đồng ý màu đỏ in đậm
        ]);
    };
</script>

{{-- --- 5. REAL-TIME NOTIFICATION SYSTEM (PUSHER) - NEW ENGINE --- --}}
{{-- Sử dụng CDN mới nhất để đảm bảo tính năng ổn định như Admin --}}
<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
<script>
    var pusher = new Pusher('bbd581278169e135dc72', {
        cluster: 'ap1'
    });
    var channel = pusher.subscribe('notifications');

    channel.bind('system.message', function(data) {
        // Lấy dữ liệu notification chuẩn hóa từ Backend (SystemNotification.php)
        const noti = data.notification;

        if (!noti) return;

        // 1. Xử lý Icon hiển thị cạnh tiêu đề
        let iconHtml = '<i class="fa-solid fa-bell text-warning"></i>';

        if (noti.type === 'success') {
            iconHtml = '<i class="fa-solid fa-circle-check text-success"></i>';
        } else if (noti.type === 'error') {
            iconHtml = '<i class="fa-solid fa-circle-exclamation text-danger"></i>';
        } else if (noti.type === 'warning') {
            iconHtml = '<i class="fa-solid fa-triangle-exclamation text-warning"></i>';
        }

        // 2. Ghép Icon vào Title
        const fullTitle = `${iconHtml} ${noti.title}`;

        // 3. Gọi hàm hiển thị
        showDynamicModal(
            fullTitle,
            noti.content,
            noti.buttons
        );
    });
</script>

@livewireScripts
</body>
</html>
