<div id="chat-interface" class="d-none">
    {{-- LAYOUT CHÍNH: Cố định chiều cao, chia 2 cột trên Desktop, chồng hàng trên Mobile --}}
    <div class="chat-layout h-100 d-flex overflow-hidden">

        {{-- ========================================================= --}}
        {{-- CỘT 1: DANH SÁCH NGƯỜI HỖ TRỢ (SIDEBAR) --}}
        {{-- ========================================================= --}}
        <div class="chat-sidebar d-flex flex-column border-end h-100" id="chat-list-col" style="border-color: var(--popup-border) !important;">

            {{-- 1. HEADER DANH SÁCH --}}
            <div class="p-3 border-bottom flex-shrink-0 d-flex align-items-center" style="border-color: var(--popup-border) !important;">

                {{-- Dropdown Menu: Đánh dấu đã đọc --}}
                <div class="dropdown me-2">
                    <button class="btn btn-sm btn-icon text-primary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-ellipsis-vertical"></i>
                    </button>
                    <ul class="dropdown-menu shadow-sm border-0 glass-effect">
                        <li>
                            <a class="dropdown-item small" href="#">
                                <i class="fa-solid fa-check-double me-2 text-primary"></i>Đánh dấu tất cả đã đọc
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Ô tìm kiếm --}}
                <input type="text" class="form-control rounded-pill" placeholder="Tìm kiếm tin nhắn..."
                       style="background-color: var(--input-darker); color: var(--text-color); border-color: var(--popup-border); font-size: 0.9rem;">
            </div>

            {{-- 2. DANH SÁCH USER/SUPPORT (CUỘN) --}}
            <div class="chat-list flex-grow-1 overflow-auto custom-scrollbar">

                {{-- Item: Support Trung Tâm (Mặc định) --}}
                <div class="chat-item p-3 d-flex align-items-center cursor-pointer active" onclick="openChat(1)">
                    <div class="position-relative">
                        <img src="https://ui-avatars.com/api/?name=Support&background=0ea5e9&color=fff"
                             class="rounded-circle me-2" width="45" height="45" alt="Avatar">
                        <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-light rounded-circle"
                              style="margin-bottom: 2px; margin-right: 8px;"></span>
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <div class="d-flex justify-content-between align-items-center">
                            {{-- Màu chữ sử dụng var(--text-color) để tự động đổi theo theme --}}
                            <h6 class="mb-0 text-truncate" style="font-size: 0.95rem; font-weight: 700; color: var(--text-color);">Hỗ Trợ Trực Tuyến</h6>
                            <small class="text-muted" style="font-size: 0.7rem;">Vừa xong</small>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="mb-0 text-truncate small" style="color: var(--text-muted);">Chào bạn, shop có thể giúp gì...</p>
                            <span class="badge bg-danger rounded-pill" style="font-size: 0.6rem;">1</span>
                        </div>
                    </div>
                </div>

                {{-- Giả lập các tư vấn viên khác --}}
                @for ($i = 2; $i <= 5; $i++)
                <div class="chat-item p-3 d-flex align-items-center cursor-pointer border-top"
                     style="border-color: var(--popup-border) !important;" onclick="openChat({{ $i }})">
                    <div class="position-relative">
                        <img src="https://ui-avatars.com/api/?name=Staff+{{ $i }}&background=64748b&color=fff"
                             class="rounded-circle me-2" width="45" height="45">
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 text-truncate" style="font-size: 0.9rem; font-weight: 600; color: var(--text-color);">Tư vấn viên {{ $i }}</h6>
                            <small class="text-muted" style="font-size: 0.7rem;">2 giờ</small>
                        </div>
                        <p class="mb-0 text-truncate small" style="color: var(--text-muted);">Đã xem</p>
                    </div>
                </div>
                @endfor
            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- CỘT 2: CỬA SỔ CHAT CHI TIẾT --}}
        {{-- ========================================================= --}}
        <div class="chat-window d-flex flex-column flex-grow-1 h-100">

            {{-- 1. HEADER CHI TIẾT (ĐÃ CẬP NHẬT BIỂU TƯỢNG) --}}
            <div class="p-3 border-bottom flex-shrink-0 d-flex align-items-center" style="border-color: var(--popup-border) !important;">
                {{-- Nút quay lại (Mobile) --}}
                <button class="btn btn-sm btn-icon me-2 mobile-nav-btn text-primary" onclick="backToChatList()">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>

                <img src="https://ui-avatars.com/api/?name=Support&background=0ea5e9&color=fff" class="rounded-circle me-2" width="35" height="35">
                <div class="flex-grow-1">
                    <h6 class="mb-0" style="font-size: 0.9rem; font-weight: 700; color: var(--text-color);">Hỗ Trợ Trực Tuyến</h6>
                    <small class="text-success" style="font-size: 0.75rem;">Đang hoạt động</small>
                </div>

                {{-- KHU VỰC BIỂU TƯỢNG: Đã đổi màu và thêm Info/Warning --}}
                <div class="chat-actions d-flex align-items-center">
                    <button class="btn btn-sm btn-icon text-primary me-1" title="Gọi điện">
                        <i class="fa-solid fa-phone"></i>
                    </button>
                    <button class="btn btn-sm btn-icon text-primary me-1" title="Video call">
                        <i class="fa-solid fa-video"></i>
                    </button>
                    {{-- Thêm biểu tượng Thông tin --}}
                    <button class="btn btn-sm btn-icon text-primary me-1" title="Thông tin">
                        <i class="fa-solid fa-circle-info"></i>
                    </button>
                    {{-- Thêm biểu tượng Cảnh báo --}}
                    <button class="btn btn-sm btn-icon text-danger" title="Báo cáo">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </button>
                </div>
            </div>

            {{-- 2. KHU VỰC TIN NHẮN (CUỘN) --}}
            <div class="chat-messages flex-grow-1 p-3 overflow-auto custom-scrollbar" style="background-color: rgba(0,0,0,0.01);">

                {{-- Support gửi --}}
                <div class="message-row d-flex mb-4">
                    <img src="https://ui-avatars.com/api/?name=Support&background=0ea5e9&color=fff"
                         class="rounded-circle me-2 flex-shrink-0" width="30" height="30">
                    <div class="message-content" style="max-width: 75%;">
                        <div class="message-bubble p-2 px-3 rounded shadow-sm mb-1"
                             style="background-color: var(--input-darker); color: var(--text-color); border: 1px solid var(--popup-border);">
                            Xin chào! Shop có thể hỗ trợ gì cho bạn không ạ?
                        </div>
                        <small class="text-muted" style="font-size: 0.65rem;">10:00 AM</small>
                    </div>
                </div>

                {{-- Khách hàng gửi --}}
                <div class="message-row d-flex mb-4 flex-row-reverse text-end">
                    <div class="message-content" style="max-width: 75%;">
                        <div class="message-bubble p-2 px-3 rounded shadow-sm text-white mb-1"
                             style="background-color: var(--primary);">
                            Mình muốn hỏi về phí vận chuyển đơn hàng ạ.
                        </div>
                        <small class="text-muted" style="font-size: 0.65rem;">10:01 AM <i class="fa-solid fa-check-double text-primary"></i></small>
                    </div>
                </div>

                {{-- Tin nhắn quan trọng từ Support (Viền primary) --}}
                <div class="message-row d-flex mb-4">
                    <img src="https://ui-avatars.com/api/?name=Support&background=0ea5e9&color=fff"
                         class="rounded-circle me-2 flex-shrink-0" width="30" height="30">
                    <div class="message-content" style="max-width: 75%;">
                        <div class="message-bubble p-2 px-3 rounded shadow-sm"
                             style="background-color: var(--link-hover-bg); color: var(--text-color); border: 1.5px solid var(--primary);">
                            Chào bạn, shop đang kiểm tra ạ. Vui lòng đợi chút nhé!
                        </div>
                    </div>
                </div>
            </div>

            {{-- 3. INPUT NHẬP LIỆU (CỐ ĐỊNH Ở ĐÁY) --}}
            <div class="chat-input-area p-3 border-top flex-shrink-0"
                 style="background: var(--popup-bg); border-color: var(--popup-border) !important; z-index: 5;">
                <div class="input-group">
                    {{-- Nút đính kèm --}}
                    <button class="btn btn-outline-secondary border-end-0 text-primary"
                            style="background-color: var(--input-darker); border-color: var(--popup-border);">
                        <i class="fa-solid fa-plus"></i>
                    </button>

                    {{-- Ô nhập tin nhắn --}}
                    <input type="text" class="form-control border-start-0 border-end-0"
                           placeholder="Nhập tin nhắn..."
                           style="background-color: var(--input-darker); color: var(--text-color); border-color: var(--popup-border);">

                    {{-- Nút gửi --}}
                    <button class="btn btn-primary px-3 shadow-sm">
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
