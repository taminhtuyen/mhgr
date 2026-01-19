<div id="chat-interface" class="d-none">

    <style>
        /* --- 1. CORE LAYOUT --- */
        #chat-interface {
            width: 800px; max-width: 100%;
            height: 500px; max-height: 100%;
            display: flex; flex-direction: column;
            transform: translateZ(0);
        }

        .chat-layout { position: relative; width: 100%; height: 100%; display: flex; overflow: hidden; }
        .chat-sidebar { width: 300px; background: rgba(0,0,0,0.02); height: 100%; display: flex; flex-direction: column; }
        .chat-window { background: transparent; height: 100%; display: flex; flex-direction: column; position: relative; }

        .chat-list, .chat-messages { overscroll-behavior: contain; }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: var(--scrollbar-thumb); border-radius: 10px; }

        /* --- 2. COLORS & UTILS --- */
        .chat-search-input::placeholder { color: var(--text-muted); opacity: 0.8; }
        .msg-meta { font-size: 0.65rem; margin-top: 4px; color: var(--text-muted); font-weight: 500; }
        body.dark-mode .msg-meta { color: #94a3b8; }

        .nav-tabs-custom .nav-link { color: var(--text-muted); border: none; border-bottom: 2px solid transparent; font-size: 0.85rem; font-weight: 600; padding: 10px 0; margin-right: 20px; background: transparent; }
        .nav-tabs-custom .nav-link.active { color: var(--primary); background: transparent; border-bottom: 2px solid var(--primary); }

        /* --- 3. SIDEBAR ACTIONS (FIX STACKING CONTEXT) --- */
        .chat-actions-btn {
            position: absolute; top: 50%; right: 10px;
            transform: translateY(-50%); z-index: 10;
        }

        /* Đẩy z-index lên cao nhất khi mở menu để không bị đè bởi các nút khác */
        .chat-actions-btn.show {
            z-index: 1000 !important;
        }

        .chat-actions-btn .btn-icon {
            color: #94a3b8;
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(0,0,0,0.05);
            transition: all 0.2s;
            width: 28px; height: 28px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 50%;
            padding: 0;
        }
        .chat-actions-btn .btn-icon:hover { color: var(--primary); background: #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }

        body.dark-mode .chat-actions-btn .btn-icon { color: #cbd5e1; background: rgba(255, 255, 255, 0.1); border-color: rgba(255, 255, 255, 0.1); }
        body.dark-mode .chat-actions-btn .btn-icon:hover { background: var(--primary); color: #fff; }

        .chat-sidebar .dropdown-menu {
            border: 1px solid var(--popup-border); box-shadow: var(--popup-shadow);
            background-color: var(--popup-bg); backdrop-filter: blur(10px);
        }
        .chat-sidebar .dropdown-item { color: var(--text-color); font-size: 0.9rem; }
        .chat-sidebar .dropdown-item:hover { background-color: var(--link-hover-bg); color: var(--link-hover-text); }

        /* --- 4. HEADER DROPDOWN --- */
        .header-dropdown-menu {
            width: 260px;
            background-color: var(--popup-bg);
            border: 1px solid var(--popup-border);
            box-shadow: var(--popup-shadow);
        }
        .header-dropdown-item {
            padding: 10px 15px; font-size: 0.9rem; display: flex; align-items: center;
            color: var(--text-color);
        }
        .header-dropdown-item:hover { background-color: var(--link-hover-bg); color: var(--primary); }
        .header-dropdown-item i { width: 25px; text-align: center; margin-right: 10px; }
        .no-arrow::after { display: none; }
        .dropdown-menu.show { z-index: 10050 !important; }

        /* --- 5. TYPING INDICATOR --- */
        .chat-typing-indicator {
            position: absolute;
            bottom: 100%;
            left: 20px;
            z-index: 20;
            display: flex; align-items: center;
            background: var(--popup-bg);
            padding: 6px 14px;
            border-radius: 16px 16px 16px 0;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.05);
            border: 1px solid var(--popup-border);
            border-bottom: none;
            backdrop-filter: blur(4px);
            margin-bottom: -4px;
            animation: slideUpFade 0.3s ease-out;
            pointer-events: none;
        }

        .typing-dots { display: flex; align-items: center; gap: 3px; }
        .typing-dots span { width: 4px; height: 4px; background: var(--primary); border-radius: 50%; display: inline-block; animation: typingBounce 1.4s infinite ease-in-out both; }
        .typing-dots span:nth-child(1) { animation-delay: -0.32s; }
        .typing-dots span:nth-child(2) { animation-delay: -0.16s; }
        @keyframes typingBounce { 0%, 80%, 100% { transform: scale(0); opacity: 0.5; } 40% { transform: scale(1); opacity: 1; } }
        @keyframes slideUpFade { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }

        /* --- 6. AUTO-EXPAND TEXTAREA & SCALABLE INPUT --- */
        #chat-input-field {
            resize: none;
            overflow-y: hidden;
            min-height: 2.6rem; /* Co giãn theo rem */
            max-height: 120px;
            line-height: 1.5;
            padding-top: 8px; padding-bottom: 8px;
        }
        #chat-input-field.scroll-active { overflow-y: auto; }

        /* Style cho các nút nhập liệu co giãn theo font-size */
        .chat-input-btn {
            height: 2.6rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }
        .chat-input-btn i {
            font-size: 1.1rem; /* Icon cũng phóng to theo rem */
        }

        /* --- 7. MOBILE RESPONSIVE --- */
        .mobile-nav-btn { display: none; }
        .desktop-nav-element { display: block; }
        .btn-back-mobile { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 50% !important; padding: 0; background-color: var(--bg-body); border: 1px solid var(--popup-border); color: var(--text-muted); transition: all 0.2s; }

        @media (max-width: 997.98px) {
            #chat-interface {
                width: 100% !important; max-width: none !important;
                height: 70vh;
            }
            #nav-popup {
                transition: height 0.1s ease-out, opacity 0.2s, transform 0.2s !important;
            }
            .chat-sidebar { width: 100%; height: 100%; position: absolute; inset: 0; z-index: 10; background: var(--popup-bg); transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1); transform: translateX(0); border-right: none; }
            .chat-window { width: 100%; height: 100%; position: absolute; inset: 0; z-index: 10; background: var(--popup-bg); transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1); transform: translateX(100%); }
            #chat-interface.in-conversation .chat-sidebar { transform: translateX(-20%); opacity: 0; pointer-events: none; }
            #chat-interface.in-conversation .chat-window { transform: translateX(0); }
            .mobile-nav-btn { display: block !important; } .desktop-nav-element { display: none !important; }
            .chat-input-area {
                padding-bottom: calc(20px + env(safe-area-inset-bottom, 0px)) !important;
            }
        }
    </style>

    <div class="chat-layout h-100 d-flex overflow-hidden">

        {{-- CỘT TRÁI: DANH SÁCH --}}
        <div class="chat-sidebar d-flex flex-column border-end h-100" id="chat-list-col" style="border-color: var(--popup-border) !important;">
            <div class="p-3 border-bottom flex-shrink-0" style="border-color: var(--popup-border) !important;">
                <div class="d-flex align-items-center mb-3">
                    <div class="dropdown me-2">
                        <button class="btn btn-sm btn-icon text-primary no-arrow" type="button" data-bs-toggle="dropdown" data-bs-container="body"><i class="fa-solid fa-bars"></i></button>
                        <ul class="dropdown-menu shadow-sm border-0 glass-effect">
                            <li><a class="dropdown-item small" href="#"><i class="fa-solid fa-check-double me-2 text-primary"></i>Đánh dấu tất cả đã đọc</a></li>
                        </ul>
                    </div>
                    <input type="text" class="form-control rounded-pill chat-search-input" placeholder="Tìm kiếm..." style="background-color: var(--input-darker); color: var(--text-color); border-color: var(--popup-border); font-size: 0.9rem;">
                </div>
                <ul class="nav nav-tabs nav-tabs-custom" id="chatTab" role="tablist">
                    <li class="nav-item" role="presentation"><button class="nav-link active" id="seller-tab" data-bs-toggle="tab" data-bs-target="#seller-pane" type="button" role="tab">Người bán</button></li>
                    <li class="nav-item" role="presentation"><button class="nav-link" id="buyer-tab" data-bs-toggle="tab" data-bs-target="#buyer-pane" type="button" role="tab">Người mua</button></li>
                    <li class="nav-item" role="presentation"><button class="nav-link" id="system-tab" data-bs-toggle="tab" data-bs-target="#system-pane" type="button" role="tab">Hệ thống</button></li>
                </ul>
            </div>

            <div class="chat-list flex-grow-1 overflow-auto custom-scrollbar" style="position: relative;">
                <div class="tab-content" id="chatTabContent">
                    {{-- TAB 1: SELLER --}}
                    <div class="tab-pane fade show active" id="seller-pane" role="tabpanel">
                        @for($k = 1; $k <= 3; $k++)
                        <div class="chat-item p-3 d-flex align-items-center cursor-pointer position-relative {{ $k == 1 ? 'active' : '' }}" onclick="openChatConversationDetail('seller_{{ $k }}')">
                            <div class="flex-shrink-0 position-relative"><img src="https://ui-avatars.com/api/?name=Seller+{{ $k }}&background=0ea5e9&color=fff" class="rounded-circle me-2" width="45" height="45"></div>
                            <div class="flex-grow-1 overflow-hidden pe-4">
                                <div class="d-flex justify-content-between align-items-center"><h6 class="mb-0 text-truncate" style="color: var(--text-color); font-size: 0.9rem; font-weight: 600;">Người bán {{ $k }}</h6><small class="text-muted" style="font-size: 0.7rem;">Hôm qua</small></div>
                                <p class="mb-0 text-truncate small mt-1 fw-bold" style="color: var(--text-color);">Đã xác nhận đơn hàng...</p>
                            </div>
                            <div class="dropdown chat-actions-btn">
                                <button class="btn btn-icon no-arrow" type="button" data-bs-toggle="dropdown" data-bs-container="body" onclick="event.stopPropagation()">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 glass-effect">
                                    <li><a class="dropdown-item small" href="#"><i class="fa-solid fa-bell me-2 text-primary"></i>Bật thông báo</a></li>
                                    <li><a class="dropdown-item small" href="#"><i class="fa-solid fa-bell-slash me-2 text-muted"></i>Tắt thông báo</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item small text-danger" href="#"><i class="fa-solid fa-ban me-2"></i>Chặn người này</a></li>
                                    <li><a class="dropdown-item small text-danger" href="#"><i class="fa-solid fa-trash me-2"></i>Xóa hội thoại</a></li>
                                </ul>
                            </div>
                        </div>
                        @endfor
                    </div>

                    {{-- TAB 2: BUYER --}}
                    <div class="tab-pane fade" id="buyer-pane" role="tabpanel">
                        @for($i = 1; $i <= 5; $i++)
                        <div class="chat-item p-3 d-flex align-items-center cursor-pointer position-relative" onclick="openChatConversationDetail('buyer_{{ $i }}')">
                            <div class="flex-shrink-0 position-relative"><img src="https://ui-avatars.com/api/?name=Buyer+{{ $i }}&background=random" class="rounded-circle me-2" width="45" height="45"></div>
                            <div class="flex-grow-1 overflow-hidden pe-4">
                                <div class="d-flex justify-content-between align-items-center"><h6 class="mb-0 text-truncate" style="color: var(--text-color); font-size: 0.9rem; font-weight: 600;">Người mua {{ $i }}</h6><small class="text-muted" style="font-size: 0.7rem;">10:30</small></div>
                                <p class="mb-0 text-truncate small mt-1" style="color: var(--text-muted);">Sản phẩm này còn hàng...</p>
                            </div>
                            <div class="dropdown chat-actions-btn">
                                <button class="btn btn-icon no-arrow" type="button" data-bs-toggle="dropdown" data-bs-container="body" onclick="event.stopPropagation()">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 glass-effect">
                                    <li><a class="dropdown-item small" href="#"><i class="fa-solid fa-bell me-2 text-primary"></i>Bật thông báo</a></li>
                                    <li><a class="dropdown-item small" href="#"><i class="fa-solid fa-bell-slash me-2 text-muted"></i>Tắt thông báo</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item small text-danger" href="#"><i class="fa-solid fa-ban me-2"></i>Chặn người này</a></li>
                                    <li><a class="dropdown-item small text-danger" href="#"><i class="fa-solid fa-trash me-2"></i>Xóa hội thoại</a></li>
                                </ul>
                            </div>
                        </div>
                        @endfor
                    </div>

                    {{-- TAB 3: SYSTEM --}}
                    <div class="tab-pane fade" id="system-pane" role="tabpanel">
                        <div class="chat-item p-3 d-flex align-items-center cursor-pointer position-relative" style="border-bottom: 1px solid var(--popup-border); background-color: rgba(var(--primary), 0.03);" onclick="openChatConversationDetail('system_main')">
                            <div class="flex-shrink-0 position-relative"><div class="rounded-circle d-flex align-items-center justify-content-center me-2 text-white" style="width: 45px; height: 45px; background: linear-gradient(45deg, #ff416c, #ff4b2b);"><i class="fa-solid fa-robot"></i></div></div>
                            <div class="flex-grow-1 overflow-hidden pe-4"><div class="d-flex justify-content-between align-items-center"><h6 class="mb-0 text-truncate fw-bold" style="color: var(--text-color); font-size: 0.9rem;">HỆ THỐNG</h6><small class="text-muted" style="font-size: 0.7rem;">Vừa xong</small></div><p class="mb-0 text-truncate small mt-1" style="color: var(--text-muted);">Chào mừng bạn...</p></div>

                            <div class="dropdown chat-actions-btn">
                                <button class="btn btn-icon no-arrow" type="button" data-bs-toggle="dropdown" data-bs-container="body" onclick="event.stopPropagation()"><i class="fa-solid fa-ellipsis"></i></button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 glass-effect">
                                    <li><a class="dropdown-item small" href="#"><i class="fa-solid fa-bell me-2 text-primary"></i>Bật thông báo</a></li>
                                    <li><a class="dropdown-item small" href="#"><i class="fa-solid fa-bell-slash me-2 text-muted"></i>Tắt thông báo</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item small text-danger" href="#"><i class="fa-solid fa-trash me-2"></i>Xóa hội thoại</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- CỘT PHẢI: CỬA SỔ CHAT --}}
        <div class="chat-window flex-grow-1 d-flex flex-column h-100" id="chat-content-col">

            {{-- HEADER (FIXED OVERFLOW & TRUNCATE) --}}
            <div class="chat-header p-3 border-bottom d-flex align-items-center flex-shrink-0"
                 style="background: var(--popup-bg); backdrop-filter: blur(5px); border-color: var(--popup-border) !important; z-index: 5;">
                <button class="btn btn-back-mobile me-3 mobile-nav-btn shadow-sm" onclick="backToChatConversationList()"><i class="fa-solid fa-chevron-left"></i></button>

                <img src="https://ui-avatars.com/api/?name=Seller+1&background=random" class="rounded-circle me-2" width="40" height="40">

                {{-- Ép tiêu đề không tràn dòng khi font-size tăng --}}
                <div style="line-height: 1.4; min-width: 0; flex: 1;">
                    <div class="fw-bold text-truncate" style="color: var(--text-color); font-size: 0.95rem;">Người bán 1</div>
                    <div class="small text-success d-flex align-items-center text-truncate" style="font-size: 0.7rem;">
                        <i class="fa-solid fa-circle me-1 flex-shrink-0" style="font-size: 0.4rem;"></i>
                        <span class="text-truncate">Đang hoạt động</span>
                    </div>
                </div>

                <div class="ms-auto d-flex align-items-center gap-2 flex-shrink-0">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-icon text-secondary no-arrow" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Tuỳ chọn">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 header-dropdown-menu glass-effect">
                            <li><a class="dropdown-item header-dropdown-item" href="#"><i class="fa-brands fa-facebook-messenger text-primary"></i> Nhắn qua Messenger</a></li>
                            <li><a class="dropdown-item header-dropdown-item" href="#"><i class="fa-solid fa-comment-sms text-info"></i> Nhắn qua Zalo</a></li>
                            <li><a class="dropdown-item header-dropdown-item" href="#"><i class="fa-solid fa-phone text-success"></i> Gọi điện thoại</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item header-dropdown-item" href="#"><i class="fa-regular fa-id-card text-secondary"></i> Xem trang cá nhân</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item header-dropdown-item text-warning" href="#"><i class="fa-solid fa-triangle-exclamation"></i> Báo cáo sai phạm</a></li>
                            <li><a class="dropdown-item header-dropdown-item text-danger" href="#"><i class="fa-solid fa-ban"></i> Chặn người này</a></li>
                        </ul>
                    </div>
                    <button class="btn btn-sm btn-icon text-muted" onclick="closeAll()" title="Đóng chat">
                        <i class="fa-solid fa-xmark" style="font-size: 1.1rem;"></i>
                    </button>
                </div>
            </div>

            {{-- MESSAGES --}}
            <div class="chat-messages flex-grow-1 p-3 overflow-auto custom-scrollbar bg-transparent">
                @for($j = 1; $j <= 3; $j++)
                <div class="message-row d-flex mb-3">
                    <img src="https://ui-avatars.com/api/?name=User&background=random" class="rounded-circle me-2 mt-1" width="30" height="30">
                    <div class="message-wrapper" style="max-width: 75%;">
                        <div class="message-bubble p-2 px-3 rounded shadow-sm" style="background-color: var(--link-hover-bg); color: var(--text-color); border: 1px solid transparent;">Chào bạn, sản phẩm này còn hàng ạ.</div>
                        <div class="msg-meta ms-1">10:0{{ $j }} AM</div>
                    </div>
                </div>
                <div class="message-row d-flex mb-3 flex-row-reverse">
                    <div class="message-wrapper text-end" style="max-width: 75%;">
                        <div class="message-bubble p-2 px-3 rounded shadow-sm text-start" style="background-color: var(--link-hover-bg); color: var(--text-color); border: 1.5px solid var(--primary);">Vâng, giao sớm giúp mình nhé!</div>
                        <div class="msg-meta me-1">10:0{{ $j + 1 }} AM &bull; <span><i class="fa-solid fa-check"></i> Đã gửi</span></div>
                    </div>
                </div>
                @endfor
            </div>

            {{-- INPUT AREA (SCALABLE) --}}
            <div class="chat-input-area p-3 border-top flex-shrink-0 position-relative"
                 style="background: var(--popup-bg); border-color: var(--popup-border) !important; z-index: 5;">

                <div id="typing-indicator" class="chat-typing-indicator d-none">
                    <div class="typing-dots">
                        <span></span><span></span><span></span>
                    </div>
                    <small class="text-muted ms-2" style="font-size: 0.75rem;">Người bán đang soạn tin...</small>
                </div>

                <div class="input-group align-items-end" style="gap: 2px;">
                    {{-- Nút thêm tệp co giãn theo rem --}}
                    <button class="btn btn-outline-secondary border-end-0 text-primary chat-input-btn"
                            style="background-color: var(--bg-body); border-color: var(--popup-border); width: 2.6rem; border-radius: 8px 0 0 8px !important;">
                        <i class="fa-solid fa-plus"></i>
                    </button>

                    <textarea id="chat-input-field" class="form-control border-start-0 border-end-0 chat-search-input"
                              rows="1"
                              placeholder="Nhập tin nhắn..."
                              style="background-color: var(--bg-body); color: var(--text-color); border-color: var(--popup-border);"></textarea>

                    {{-- Nút gửi co giãn theo rem --}}
                    <button id="btn-send-message" class="btn btn-primary chat-input-btn"
                            style="width: 3.2rem; border-radius: 0 8px 8px 0 !important;">
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const chatInterface = document.getElementById('chat-interface');
        const popup = document.getElementById('nav-popup');
        const inputField = document.getElementById('chat-input-field');
        const typingIndicator = document.getElementById('typing-indicator');
        const btnSend = document.getElementById('btn-send-message');

        // --- 1. CONFIG: LOAD TỪ STORAGE ---
        // Biến này sẽ được cập nhật bởi settings-popup
        window.updateChatConversationSettings = function() {
            window.chatSettings = {
                enterToSend: localStorage.getItem('client_chat_enter_to_send') === 'true'
            };
        };
        window.updateChatConversationSettings(); // Load initial

        // --- 2. SEND MESSAGE LOGIC ---
        function sendMessage() {
            const msg = inputField.value.trim();
            if (!msg) return;
            console.log('Client sending message:', msg);
            inputField.value = '';
            inputField.style.height = 'auto';
        }

        // --- 3. AUTO-GROW TEXTAREA ---
        if (inputField) {
            inputField.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
                if (this.scrollHeight > 120) this.classList.add('scroll-active');
                else this.classList.remove('scroll-active');
            });

            inputField.addEventListener('keydown', function(e) {
                // Kiểm tra setting mỗi lần gõ hoặc dùng biến global
                const enterToSend = localStorage.getItem('client_chat_enter_to_send') === 'true';

                if (enterToSend && e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    sendMessage();
                }
            });
        }

        if (btnSend) {
            btnSend.addEventListener('click', (e) => {
                e.preventDefault();
                sendMessage();
            });
        }

        // --- 4. DROPDOWN FIX (STACKING CONTEXT) ---
        const actionButtons = document.querySelectorAll('.chat-actions-btn [data-bs-toggle="dropdown"]');

        actionButtons.forEach(btn => {
            btn.addEventListener('show.bs.dropdown', function () {
                actionButtons.forEach(otherBtn => {
                    if (otherBtn !== btn) {
                        const dropdown = bootstrap.Dropdown.getInstance(otherBtn);
                        if (dropdown) dropdown.hide();
                    }
                });

                const parentDiv = btn.closest('.chat-actions-btn');
                if(parentDiv) parentDiv.classList.add('show');
            });

            btn.addEventListener('hidden.bs.dropdown', function () {
                const parentDiv = btn.closest('.chat-actions-btn');
                if(parentDiv) parentDiv.classList.remove('show');
            });
        });

        // --- 5. MOBILE FIX ---
        if (window.visualViewport && window.innerWidth < 998) {
            const handleResize = () => {
                if (!chatInterface.classList.contains('d-none') && popup.classList.contains('active')) {
                    const viewportHeight = window.visualViewport.height;
                    if (viewportHeight < window.innerHeight * 0.85) {
                        popup.style.height = `${viewportHeight}px`;
                        popup.style.bottom = '0px';
                        chatInterface.style.height = '100%';
                    } else {
                        window.resetChatConversationPopupStyle();
                    }
                }
            };
            window.visualViewport.addEventListener('resize', handleResize);
            window.visualViewport.addEventListener('scroll', handleResize);

            window.resetChatConversationPopupStyle = function() {
                popup.style.height = '';
                popup.style.bottom = '';
                chatInterface.style.height = '';
            }
        } else {
            window.resetChatConversationPopupStyle = function() {};
        }

        // --- 6. API ---
        window.showTyping = function() { if(typingIndicator) typingIndicator.classList.remove('d-none'); }
        window.hideTyping = function() { if(typingIndicator) typingIndicator.classList.add('d-none'); }

        window.openChatConversationDetail = function(id) {
            chatInterface.classList.add('in-conversation');
        }

        window.backToChatConversationList = function() {
            chatInterface.classList.remove('in-conversation');
        }

        window.renderChatConversationContent = function() {
            const menuInterface = document.getElementById('menu-interface');
            const chatInterface = document.getElementById('chat-interface');
            const settingsInterface = document.getElementById('settings-interface');

            if(menuInterface) menuInterface.classList.add('d-none');
            if(settingsInterface) settingsInterface.classList.add('d-none');
            if(chatInterface) chatInterface.classList.remove('d-none');
            if (window.visualViewport) window.visualViewport.dispatchEvent(new Event('resize'));
        }

        const oldCloseAll = window.closeAll;
        window.closeAll = function() {
            if(oldCloseAll) oldCloseAll();
            if(window.resetChatConversationPopupStyle) window.resetChatConversationPopupStyle();
        }

    });
</script>
