<div id="chat-interface" class="d-none">
    {{-- LAYOUT CHÍNH: Cố định chiều cao 100% của cha, ẩn thanh cuộn thừa --}}
    <div class="chat-layout h-100 d-flex overflow-hidden">

        {{-- ========================================================= --}}
        {{-- CỘT TRÁI: DANH SÁCH NGƯỜI DÙNG --}}
        {{-- ========================================================= --}}
        <div class="chat-sidebar d-flex flex-column border-end h-100" id="chat-list-col" style="border-color: var(--popup-border) !important;">

            {{-- 1. HEADER TÌM KIẾM (CỐ ĐỊNH) --}}
            <div class="p-3 border-bottom flex-shrink-0 d-flex align-items-center" style="border-color: var(--popup-border) !important;">

                {{-- Dropdown Menu 3 chấm - Đã đổi sang text-primary cho nổi bật --}}
                <div class="dropdown me-2">
                    <button class="btn btn-sm btn-icon text-primary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-ellipsis-vertical"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><i class="fa-solid fa-check-double me-2 text-primary"></i>Đánh dấu tất cả đã đọc</a></li>
                    </ul>
                </div>

                <input type="text" class="form-control rounded-pill" placeholder="Tìm kiếm tin nhắn..."
                       style="background-color: var(--bg-body); color: var(--text-color); border-color: var(--popup-border);">
            </div>

            {{-- 2. DANH SÁCH USER (CUỘN ĐỘC LẬP) --}}
            <div class="chat-list flex-grow-1 overflow-auto custom-scrollbar" style="overflow-y: auto;">
                {{-- Mockup Items --}}
                @for($i = 1; $i <= 10; $i++)
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

                {{-- CÁC BIỂU TƯỢNG HÀNH ĐỘNG: Đã đổi màu nổi bật --}}
                <div class="ms-auto d-flex align-items-center gap-1">
                    <button class="btn btn-sm btn-icon text-primary" title="Gọi điện">
                        <i class="fa-solid fa-phone"></i>
                    </button>
                    <button class="btn btn-sm btn-icon text-primary" title="Video call">
                        <i class="fa-solid fa-video"></i>
                    </button>
                    <button class="btn btn-sm btn-icon text-primary" title="Thông tin">
                        <i class="fa-solid fa-circle-info"></i>
                    </button>

                    {{-- NÚT BÁO CÁO XẤU --}}
                    <button class="btn btn-sm btn-icon text-danger ms-1" title="Báo cáo xấu">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </button>
                </div>
            </div>

            {{-- 2. NỘI DUNG TIN NHẮN (CUỘN ĐỘC LẬP) --}}
            <div class="chat-messages flex-grow-1 p-3 overflow-auto custom-scrollbar bg-transparent" style="overflow-y: auto;">
                @for($j = 1; $j <= 5; $j++)
                {{-- Tin nhắn đối phương --}}
                <div class="message-row d-flex mb-3">
                    <img src="https://ui-avatars.com/api/?name=User&background=random" class="rounded-circle me-2 mt-1" width="30" height="30">
                    <div class="message-bubble p-2 px-3 rounded shadow-sm"
                         style="background-color: var(--link-hover-bg); color: var(--text-color); max-width: 75%; border: 1px solid transparent;">
                        Xin chào shop, cho tôi hỏi về đơn hàng #{{ $j }}992 với ạ?
                    </div>
                </div>

                {{-- Tin nhắn của chính mình: Nền nhạt + Viền xanh --}}
                <div class="message-row d-flex mb-3 flex-row-reverse">
                    <div class="message-bubble p-2 px-3 rounded shadow-sm"
                         style="background-color: var(--link-hover-bg); color: var(--text-color); max-width: 75%; border: 1.5px solid var(--primary);">
                        Chào bạn, shop đang kiểm tra ạ. Vui lòng đợi chút nhé!
                    </div>
                </div>
                @endfor
            </div>

            {{-- 3. INPUT NHẬP LIỆU (CỐ ĐỊNH Ở ĐÁY) --}}
            <div class="chat-input-area p-3 border-top flex-shrink-0"
                 style="background: var(--popup-bg); border-color: var(--popup-border) !important; z-index: 5;">
                <div class="input-group">
                    {{-- Nút "+" đổi sang text-primary --}}
                    <button class="btn btn-outline-secondary border-end-0 text-primary"
                            style="background-color: var(--bg-body); border-color: var(--popup-border);">
                        <i class="fa-solid fa-plus"></i>
                    </button>

                    <input type="text" class="form-control border-start-0 border-end-0"
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
