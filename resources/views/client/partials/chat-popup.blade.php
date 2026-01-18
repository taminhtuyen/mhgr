<div id="chat-interface" class="d-none">

    <style>
        /* --- CHAT MODULE CSS --- */

        /* 1. Layout & Scrollbars */
        #chat-interface { max-width: 800px; width: 800px; height: 500px; max-height: 100%; display: flex; flex-direction: column; }
        .chat-layout { position: relative; width: 100%; height: 100%; display: flex; overflow: hidden; }
        .chat-sidebar { width: 300px; background: rgba(0,0,0,0.02); height: 100%; display: flex; flex-direction: column; }
        .chat-window { background: transparent; height: 100%; display: flex; flex-direction: column; }
        .chat-list, .chat-messages { overscroll-behavior: contain; }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: var(--scrollbar-thumb); border-radius: 10px; }

        /* 2. Colors & Inputs */
        .chat-search-input::placeholder { color: var(--text-muted); opacity: 0.8; }
        .msg-meta { font-size: 0.65rem; margin-top: 4px; color: var(--text-muted); font-weight: 500; }
        body.dark-mode .msg-meta { color: #94a3b8; }

        /* 3. Custom Tabs */
        .nav-tabs-custom .nav-link { color: var(--text-muted); border: none; border-bottom: 2px solid transparent; font-size: 0.85rem; font-weight: 600; padding: 10px 0; margin-right: 20px; background: transparent; }
        .nav-tabs-custom .nav-link:hover { color: var(--primary); }
        .nav-tabs-custom .nav-link.active { color: var(--primary); background: transparent; border-bottom: 2px solid var(--primary); }

        /* 4. Action Buttons (3 dots) */
        .chat-actions-btn { position: absolute; top: 50%; right: 10px; transform: translateY(-50%); z-index: 10; }
        .chat-actions-btn .btn-icon { color: #94a3b8; background: rgba(255, 255, 255, 0.5); border: 1px solid rgba(0,0,0,0.05); transition: all 0.2s; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; border-radius: 50%; }
        .chat-actions-btn .btn-icon:hover { color: var(--primary); background: #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        body.dark-mode .chat-actions-btn .btn-icon { color: #cbd5e1; background: rgba(255, 255, 255, 0.1); border-color: rgba(255, 255, 255, 0.1); }
        body.dark-mode .chat-actions-btn .btn-icon:hover { background: var(--primary); color: #fff; }

        /* 5. Mobile Navigation */
        .btn-back-mobile { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 50% !important; padding: 0; background-color: var(--bg-body); border: 1px solid var(--popup-border); color: var(--text-muted); transition: all 0.2s; }
        .btn-back-mobile:hover { color: var(--primary); border-color: var(--primary); background-color: var(--link-hover-bg); transform: translateX(-2px); }
        .mobile-nav-btn { display: none; } .desktop-nav-element { display: block; }

        .chat-sidebar .dropdown-menu { border: 1px solid var(--popup-border); box-shadow: var(--popup-shadow); background-color: var(--popup-bg); backdrop-filter: blur(10px); }
        .chat-sidebar .dropdown-item { color: var(--text-color); }
        .chat-sidebar .dropdown-item:hover { background-color: var(--link-hover-bg); color: var(--link-hover-text); }
        .no-arrow::after { display: none; } .dropdown-menu.show { z-index: 10050 !important; }

        /* Mobile Responsive Logic */
        @media (max-width: 997.98px) {
            #chat-interface { width: 100% !important; height: 70vh !important; max-width: none !important; }
            .chat-sidebar { width: 100%; height: 100%; position: absolute; inset: 0; z-index: 2; background: var(--popup-bg); transition: transform 0.3s; transform: translateX(0); }
            .chat-window { width: 100%; height: 100%; position: absolute; inset: 0; z-index: 2; background: var(--popup-bg); transition: transform 0.3s; transform: translateX(100%); }
            #chat-interface.in-conversation .chat-sidebar { transform: translateX(-100%); }
            #chat-interface.in-conversation .chat-window { transform: translateX(0); }
            .mobile-nav-btn { display: block !important; } .desktop-nav-element { display: none !important; }
        }
    </style>

    <div class="chat-layout h-100 d-flex overflow-hidden">

        {{-- ========================================================= --}}
        {{-- CỘT TRÁI: DANH SÁCH (DEMO FULL DATA) --}}
        {{-- ========================================================= --}}
        <div class="chat-sidebar d-flex flex-column border-end h-100" id="chat-list-col" style="border-color: var(--popup-border) !important;">

            {{-- HEADER SIDEBAR --}}
            <div class="p-3 border-bottom flex-shrink-0" style="border-color: var(--popup-border) !important;">
                <div class="d-flex align-items-center mb-3">
                    <div class="dropdown me-2">
                        <button class="btn btn-sm btn-icon text-primary no-arrow" type="button" data-bs-toggle="dropdown" data-bs-container="body">
                            <i class="fa-solid fa-bars"></i>
                        </button>
                        <ul class="dropdown-menu shadow-sm border-0 glass-effect">
                            <li><a class="dropdown-item small" href="#"><i class="fa-solid fa-check-double me-2 text-primary"></i>Đánh dấu tất cả đã đọc</a></li>
                            <li><a class="dropdown-item small" href="#"><i class="fa-solid fa-gear me-2 text-muted"></i>Cài đặt chat</a></li>
                        </ul>
                    </div>
                    <input type="text" class="form-control rounded-pill chat-search-input" placeholder="Tìm kiếm..."
                           style="background-color: var(--input-darker); color: var(--text-color); border-color: var(--popup-border); font-size: 0.9rem;">
                </div>

                {{-- TABS: NGƯỜI BÁN -> NGƯỜI MUA -> HỆ THỐNG --}}
                <ul class="nav nav-tabs nav-tabs-custom" id="chatTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="seller-tab" data-bs-toggle="tab" data-bs-target="#seller-pane" type="button" role="tab">Người bán</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="buyer-tab" data-bs-toggle="tab" data-bs-target="#buyer-pane" type="button" role="tab">Người mua</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="system-tab" data-bs-toggle="tab" data-bs-target="#system-pane" type="button" role="tab">Hệ thống</button>
                    </li>
                </ul>
            </div>

            {{-- DANH SÁCH CUỘN --}}
            <div class="chat-list flex-grow-1 overflow-auto custom-scrollbar" style="position: relative;">

                <div class="tab-content" id="chatTabContent">

                    {{-- TAB 1: NGƯỜI BÁN (Seller) --}}
                    <div class="tab-pane fade show active" id="seller-pane" role="tabpanel">
                        @for($k = 1; $k <= 3; $k++)
                        <div class="chat-item p-3 d-flex align-items-center cursor-pointer position-relative {{ $k == 1 ? 'active' : '' }}" onclick="openChatDetail('seller_{{ $k }}')">
                            <div class="flex-shrink-0 position-relative">
                                <img src="https://ui-avatars.com/api/?name=Seller+{{ $k }}&background=0ea5e9&color=fff" class="rounded-circle me-2" width="45" height="45">
                            </div>

                            <div class="flex-grow-1 overflow-hidden pe-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 text-truncate" style="color: var(--text-color); font-size: 0.9rem; font-weight: 600;">Người bán {{ $k }}</h6>
                                    <small class="text-muted" style="font-size: 0.7rem;">Hôm qua</small>
                                </div>
                                <p class="mb-0 text-truncate small mt-1 fw-bold" style="color: var(--text-color);">Đã xác nhận đơn hàng của bạn...</p>
                            </div>

                            <div class="dropdown chat-actions-btn">
                                <button class="btn btn-icon no-arrow" type="button" data-bs-toggle="dropdown" data-bs-container="body" onclick="event.stopPropagation()">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 glass-effect">
                                    <li><a class="dropdown-item small" href="#"><i class="fa-solid fa-bell-slash me-2 text-muted"></i>Tắt thông báo</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item small text-danger" href="#"><i class="fa-solid fa-trash me-2"></i>Xóa hội thoại</a></li>
                                </ul>
                            </div>
                        </div>
                        @endfor
                    </div>

                    {{-- TAB 2: NGƯỜI MUA (Buyer) --}}
                    <div class="tab-pane fade" id="buyer-pane" role="tabpanel">
                        @for($i = 1; $i <= 5; $i++)
                        <div class="chat-item p-3 d-flex align-items-center cursor-pointer position-relative" onclick="openChatDetail('buyer_{{ $i }}')">
                            <div class="flex-shrink-0 position-relative">
                                <img src="https://ui-avatars.com/api/?name=Buyer+{{ $i }}&background=random" class="rounded-circle me-2" width="45" height="45">
                                <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-light rounded-circle" style="margin-bottom: 2px; margin-right: 8px;"></span>
                            </div>

                            <div class="flex-grow-1 overflow-hidden pe-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 text-truncate" style="color: var(--text-color); font-size: 0.9rem; font-weight: 600;">Người mua {{ $i }}</h6>
                                    <small class="text-muted" style="font-size: 0.7rem;">10:30</small>
                                </div>
                                <p class="mb-0 text-truncate small mt-1" style="color: var(--text-muted);">Sản phẩm này còn hàng không ạ...</p>
                            </div>

                            <div class="dropdown chat-actions-btn">
                                <button class="btn btn-icon no-arrow" type="button" data-bs-toggle="dropdown" data-bs-container="body" onclick="event.stopPropagation()">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 glass-effect">
                                    <li><a class="dropdown-item small" href="#"><i class="fa-solid fa-bell-slash me-2 text-muted"></i>Tắt thông báo</a></li>
                                    <li><a class="dropdown-item small" href="#"><i class="fa-solid fa-bell me-2 text-success"></i>Bật thông báo</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item small text-danger" href="#"><i class="fa-solid fa-trash me-2"></i>Xóa hội thoại</a></li>
                                </ul>
                            </div>
                        </div>
                        @endfor
                    </div>

                    {{-- TAB 3: HỆ THỐNG (SYSTEM) --}}
                    <div class="tab-pane fade" id="system-pane" role="tabpanel">

                        {{-- 1. TIN NHẮN HỆ THỐNG CHÍNH --}}
                        <div class="chat-item p-3 d-flex align-items-center cursor-pointer position-relative"
                             style="border-bottom: 1px solid var(--popup-border); background-color: rgba(var(--primary), 0.03);"
                             onclick="openChatDetail('system_main')">
                            <div class="flex-shrink-0 position-relative">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-2 text-white"
                                     style="width: 45px; height: 45px; background: linear-gradient(45deg, #ff416c, #ff4b2b);">
                                    <i class="fa-solid fa-robot"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 overflow-hidden pe-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 text-truncate fw-bold" style="color: var(--text-color); font-size: 0.9rem;">HỆ THỐNG</h6>
                                    <small class="text-muted" style="font-size: 0.7rem;">Vừa xong</small>
                                </div>
                                <p class="mb-0 text-truncate small mt-1" style="color: var(--text-muted);">Chào mừng bạn đến với sàn thương mại...</p>
                            </div>
                        </div>

                        {{-- 2. DANH SÁCH NHÂN VIÊN --}}
                        @for($s = 1; $s <= 3; $s++)
                        <div class="chat-item p-3 d-flex align-items-center cursor-pointer position-relative" onclick="openChatDetail('staff_{{ $s }}')">
                            <div class="flex-shrink-0 position-relative">
                                <img src="https://ui-avatars.com/api/?name=Staff+{{ $s }}&background=64748b&color=fff" class="rounded-circle me-2" width="45" height="45">
                                <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-light rounded-circle" style="margin-bottom: 2px; margin-right: 8px;"></span>
                            </div>

                            <div class="flex-grow-1 overflow-hidden pe-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 text-truncate" style="color: var(--text-color); font-size: 0.9rem; font-weight: 600;">Nhân Viên {{ $s }}</h6>
                                    <small class="text-muted" style="font-size: 0.7rem;">08:00</small>
                                </div>
                                <p class="mb-0 text-truncate small mt-1" style="color: var(--text-muted);">Hỗ trợ vấn đề đơn hàng...</p>
                            </div>

                            <div class="dropdown chat-actions-btn">
                                <button class="btn btn-icon no-arrow" type="button" data-bs-toggle="dropdown" data-bs-container="body" onclick="event.stopPropagation()">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 glass-effect">
                                    <li><a class="dropdown-item small" href="#"><i class="fa-solid fa-bell-slash me-2 text-muted"></i>Tắt thông báo</a></li>
                                    <li><a class="dropdown-item small" href="#"><i class="fa-solid fa-bell me-2 text-success"></i>Bật thông báo</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item small text-danger" href="#"><i class="fa-solid fa-trash me-2"></i>Xóa hội thoại</a></li>
                                </ul>
                            </div>
                        </div>
                        @endfor

                    </div>
                </div>
            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- CỘT PHẢI: CỬA SỔ CHAT (DEMO FULL DATA) --}}
        {{-- ========================================================= --}}
        <div class="chat-window flex-grow-1 d-flex flex-column h-100" id="chat-content-col">

            {{-- HEADER WINDOW --}}
            <div class="chat-header p-3 border-bottom d-flex align-items-center flex-shrink-0"
                 style="background: var(--popup-bg); backdrop-filter: blur(5px); border-color: var(--popup-border) !important; z-index: 5;">

                {{-- Nút Back Mobile --}}
                <button class="btn btn-back-mobile me-3 mobile-nav-btn shadow-sm" onclick="backToChatList()">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>

                <img src="https://ui-avatars.com/api/?name=Seller+1&background=random" class="rounded-circle me-2" width="35" height="35">
                <div>
                    <div class="fw-bold lh-1" style="color: var(--text-color); font-size: 0.95rem;">Người bán 1</div>
                    <small class="text-success desktop-nav-element" style="font-size: 0.75rem;"><i class="fa-solid fa-circle" style="font-size: 8px;"></i> Online</small>
                </div>

                <div class="ms-auto d-flex align-items-center gap-1">
                    <button class="btn btn-sm btn-icon text-primary" title="Gọi điện"><i class="fa-solid fa-phone"></i></button>
                    <button class="btn btn-sm btn-icon text-primary" title="Video call"><i class="fa-solid fa-video"></i></button>
                    <button class="btn btn-sm btn-icon text-primary" title="Thông tin"><i class="fa-solid fa-circle-info"></i></button>
                    <button class="btn btn-sm btn-icon text-danger ms-1" title="Báo cáo xấu"><i class="fa-solid fa-triangle-exclamation"></i></button>
                </div>
            </div>

            {{-- MESSAGES LIST --}}
            <div class="chat-messages flex-grow-1 p-3 overflow-auto custom-scrollbar bg-transparent">
                @for($j = 1; $j <= 3; $j++)
                {{-- A. Người khác gửi (Seller) --}}
                <div class="message-row d-flex mb-3">
                    <img src="https://ui-avatars.com/api/?name=User&background=random" class="rounded-circle me-2 mt-1" width="30" height="30">
                    <div class="message-wrapper" style="max-width: 75%;">
                        <div class="message-bubble p-2 px-3 rounded shadow-sm"
                             style="background-color: var(--link-hover-bg); color: var(--text-color); border: 1px solid transparent;">
                            Chào bạn, sản phẩm này bên mình vẫn còn hàng ạ.
                        </div>
                        <div class="msg-meta ms-1">10:0{{ $j }} AM</div>
                    </div>
                </div>

                {{-- B. Mình gửi (Client) --}}
                <div class="message-row d-flex mb-3 flex-row-reverse">
                    <div class="message-wrapper text-end" style="max-width: 75%;">
                        <div class="message-bubble p-2 px-3 rounded shadow-sm text-start"
                             style="background-color: var(--link-hover-bg); color: var(--text-color); border: 1.5px solid var(--primary);">
                            Vâng, shop giao sớm giúp mình nhé!
                        </div>
                        <div class="msg-meta me-1">
                            10:0{{ $j + 1 }} AM &bull;
                            @if($j == 3)
                            <span class="text-primary"><i class="fa-solid fa-check-double"></i> Đã xem</span>
                            @elseif($j == 2)
                            <span><i class="fa-solid fa-check-double"></i> Đã nhận</span>
                            @else
                            <span><i class="fa-solid fa-check"></i> Đã gửi</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endfor
            </div>

            {{-- INPUT AREA --}}
            <div class="chat-input-area p-3 border-top flex-shrink-0"
                 style="background: var(--popup-bg); border-color: var(--popup-border) !important; z-index: 5;">
                <div class="input-group">
                    <button class="btn btn-outline-secondary border-end-0 text-primary"
                            style="background-color: var(--bg-body); border-color: var(--popup-border);">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                    <input type="text" class="form-control border-start-0 border-end-0 chat-search-input"
                           placeholder="Nhập tin nhắn..."
                           style="background-color: var(--bg-body); color: var(--text-color); border-color: var(--popup-border);">
                    <button class="btn btn-primary px-3">
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // --- CHAT LOGIC ---
        const chatInterface = document.getElementById('chat-interface');

        // Hàm mở chi tiết chat (Demo: chỉ cần thêm class để mobile hiển thị đè lên)
        window.openChatDetail = function(id) {
            chatInterface.classList.add('in-conversation');
            console.log("Opening chat with ID:", id); // Log để debug sau này
        }

        // Hàm quay lại danh sách (Cho Mobile)
        window.backToChatList = function() {
            chatInterface.classList.remove('in-conversation');
        }

        // --- EXPORT RENDER FUNCTION ---
        // Hàm này được gọi từ bubbles.blade.php khi click vào bong bóng Chat
        window.renderChatContent = function() {
            const menuInterface = document.getElementById('menu-interface');
            const chatInterface = document.getElementById('chat-interface');

            // Ẩn Menu, Hiện Chat
            if(menuInterface) menuInterface.classList.add('d-none');
            if(chatInterface) chatInterface.classList.remove('d-none');
        }
    });
</script>
