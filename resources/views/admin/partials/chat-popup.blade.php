<div id="chat-interface" class="d-none">
    {{-- LAYOUT CHÍNH: Cố định chiều cao 100% của cha, ẩn thanh cuộn thừa --}}
    <div class="chat-layout h-100 d-flex overflow-hidden">

        {{-- ========================================================= --}}
        {{-- CỘT TRÁI: DANH SÁCH NGƯỜI DÙNG --}}
        {{-- ========================================================= --}}
        <div class="chat-sidebar d-flex flex-column border-end h-100" id="chat-list-col" style="border-color: var(--popup-border) !important;">

            {{-- 1. HEADER TÌM KIẾM (CỐ ĐỊNH) --}}
            {{-- flex-shrink-0: Đảm bảo không bị co lại khi danh sách dài --}}
            <div class="p-3 border-bottom flex-shrink-0" style="border-color: var(--popup-border) !important;">
                <input type="text" class="form-control rounded-pill" placeholder="Tìm kiếm tin nhắn..."
                       style="background-color: var(--bg-body); color: var(--text-color); border-color: var(--popup-border);">
            </div>

            {{-- 2. DANH SÁCH USER (CUỘN ĐỘC LẬP) --}}
            {{-- flex-grow-1: Chiếm hết khoảng trống còn lại --}}
            {{-- overflow-y-auto: Chỉ cuộn dọc khu vực này --}}
            <div class="chat-list flex-grow-1 overflow-auto custom-scrollbar" style="overflow-y: auto;">
                {{-- Mockup Items --}}
                @for($i = 1; $i <= 10; $i++) {{-- Loop thử nhiều item để test scroll --}}
                <div class="chat-item p-3 d-flex align-items-center cursor-pointer {{ $i == 1 ? 'active' : '' }}" onclick="openChat({{ $i }})">
                    <img src="https://ui-avatars.com/api/?name=User+{{ $i }}&background=random" class="rounded-circle me-2" width="40" height="40">
                    <div class="flex-grow-1 overflow-hidden">
                        <div class="d-flex justify-content-between">
                            <strong class="text-truncate" style="color: var(--text-color);">Người dùng {{ $i }}</strong>
                            <small class="text-muted">12:0{{ $i }}</small>
                        </div>
                        <div class="text-muted text-truncate small">Nội dung tin nhắn mẫu số {{ $i }}...</div>
                    </div>
                </div>
                @endfor
            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- CỘT PHẢI: CỬA SỔ CHAT --}}
        {{-- ========================================================= --}}
        <div class="chat-window flex-grow-1 d-flex flex-column h-100" id="chat-content-col">

            {{-- 1. HEADER THÔNG TIN ĐỐI PHƯƠNG (CỐ ĐỊNH) --}}
            <div class="chat-header p-3 border-bottom d-flex align-items-center flex-shrink-0"
                 style="background: var(--popup-bg); backdrop-filter: blur(5px); border-color: var(--popup-border) !important; z-index: 5;">

                {{-- Nút Back Mobile --}}
                <button class="btn btn-sm me-3 mobile-nav-btn shadow-sm"
                        onclick="backToChatList()"
                        style="background-color: var(--bg-body); border: 1px solid var(--popup-border); color: var(--text-color);">
                    <i class="fa-solid fa-arrow-left text-primary"></i>
                </button>

                <img src="https://ui-avatars.com/api/?name=Admin+A&background=random" class="rounded-circle me-2" width="35" height="35">
                <div>
                    <div class="fw-bold lh-1" style="color: var(--text-color);">Nguyễn Văn A</div>
                    <small class="text-success desktop-nav-element"><i class="fa-solid fa-circle" style="font-size: 8px;"></i> Online</small>
                </div>
                <div class="ms-auto">
                    <button class="btn btn-sm btn-icon text-muted"><i class="fa-solid fa-phone"></i></button>
                    <button class="btn btn-sm btn-icon text-muted"><i class="fa-solid fa-video"></i></button>
                    <button class="btn btn-sm btn-icon text-muted"><i class="fa-solid fa-circle-info"></i></button>
                </div>
            </div>

            {{-- 2. NỘI DUNG TIN NHẮN (CUỘN ĐỘC LẬP) --}}
            <div class="chat-messages flex-grow-1 p-3 overflow-auto custom-scrollbar bg-transparent" style="overflow-y: auto;">
                {{-- Tin nhắn mẫu dài để test scroll --}}
                @for($j = 1; $j <= 5; $j++)
                <div class="message-row d-flex mb-3">
                    <img src="https://ui-avatars.com/api/?name=User&background=random" class="rounded-circle me-2 mt-1" width="30" height="30">
                    <div class="message-bubble p-2 px-3 rounded shadow-sm"
                         style="background-color: var(--link-hover-bg); color: var(--text-color); max-width: 75%;">
                        Xin chào shop, cho tôi hỏi về đơn hàng #{{ $j }}992 với ạ?
                    </div>
                </div>

                <div class="message-row d-flex mb-3 flex-row-reverse">
                    <div class="message-bubble p-2 px-3 rounded shadow-sm text-white"
                         style="background-color: var(--primary); max-width: 75%;">
                        Chào bạn, shop đang kiểm tra ạ. Vui lòng đợi chút nhé!
                    </div>
                </div>
                @endfor
            </div>

            {{-- 3. INPUT NHẬP LIỆU (CỐ ĐỊNH Ở ĐÁY) --}}
            <div class="chat-input-area p-3 border-top flex-shrink-0"
                 style="background: var(--popup-bg); border-color: var(--popup-border) !important; z-index: 5;">
                <div class="input-group">
                    <button class="btn btn-outline-secondary border-end-0"
                            style="background-color: var(--bg-body); border-color: var(--popup-border); color: var(--text-muted);">
                        <i class="fa-solid fa-plus"></i>
                    </button>

                    <input type="text" class="form-control border-start-0 border-end-0"
                           placeholder="Nhập tin nhắn..."
                           style="background-color: var(--bg-body); color: var(--text-color); border-color: var(--popup-border);">

                    <button class="btn btn-primary">
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
