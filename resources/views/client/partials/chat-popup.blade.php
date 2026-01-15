<div id="chat-interface" class="d-none">
    {{-- LAYOUT CHÍNH: Đảm bảo full chiều cao và không cuộn ở wrapper này --}}
    <div class="chat-layout h-100 d-flex overflow-hidden">

        {{-- ========================================================= --}}
        {{-- CỘT 1: DANH SÁCH USER (SIDEBAR) --}}
        {{-- ========================================================= --}}
        <div class="chat-sidebar d-flex flex-column border-end h-100" id="chat-list-col" style="border-color: var(--popup-border) !important;">

            {{-- HEADER DANH SÁCH (CỐ ĐỊNH) --}}
            <div class="p-3 border-bottom text-center fw-bold text-primary flex-shrink-0" style="border-color: var(--popup-border) !important;">
                HỖ TRỢ TRỰC TUYẾN
            </div>

            {{-- DANH SÁCH (CUỘN) --}}
            <div class="chat-list flex-grow-1 overflow-auto custom-scrollbar" style="overflow-y: auto;">
                {{-- Item Active --}}
                <div class="chat-item p-3 d-flex align-items-center cursor-pointer active" onclick="openChat(1)">
                    <div class="position-relative">
                        <img src="https://ui-avatars.com/api/?name=Support&background=0ea5e9&color=fff" class="rounded-circle me-2" width="45" height="45">
                        <span class="position-absolute bottom-0 end-0 bg-success border border-white rounded-circle" style="width: 12px; height: 12px;"></span>
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <div class="d-flex justify-content-between">
                            <strong class="text-truncate" style="color: var(--text-color);">Chăm Sóc Khách Hàng</strong>
                        </div>
                        <div class="text-muted text-truncate small">Chúng tôi có thể giúp gì cho bạn?</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- CỘT 2: NỘI DUNG CHAT --}}
        {{-- ========================================================= --}}
        <div class="chat-window flex-grow-1 d-flex flex-column h-100" id="chat-content-col">

            {{-- HEADER CHAT (CỐ ĐỊNH) --}}
            <div class="chat-header p-3 border-bottom d-flex align-items-center flex-shrink-0"
                 style="background: var(--popup-bg); backdrop-filter: blur(5px); border-color: var(--popup-border) !important; z-index: 5;">

                <button class="btn btn-sm me-3 mobile-nav-btn shadow-sm"
                        onclick="backToChatList()"
                        style="background-color: var(--bg-body); border: 1px solid var(--popup-border); color: var(--text-color);">
                    <i class="fa-solid fa-arrow-left text-primary"></i>
                </button>

                <div class="d-flex align-items-center">
                    <div class="position-relative mobile-nav-btn me-2">
                        <img src="https://ui-avatars.com/api/?name=Support&background=0ea5e9&color=fff" class="rounded-circle" width="35" height="35">
                    </div>
                    <div>
                        <div class="fw-bold lh-1 text-primary">Chat với Admin</div>
                        <small class="text-muted desktop-nav-element" style="font-size: 0.75rem;">Luôn sẵn sàng hỗ trợ</small>
                    </div>
                </div>
            </div>

            {{-- BODY CHAT (CUỘN) --}}
            <div class="chat-messages flex-grow-1 p-3 overflow-auto custom-scrollbar bg-transparent" style="overflow-y: auto;">
                {{-- Tin nhắn mẫu --}}
                @for($i=0; $i<5; $i++)
                <div class="message-row d-flex mb-3">
                    <img src="https://ui-avatars.com/api/?name=Support&background=0ea5e9&color=fff" class="rounded-circle me-2 mt-1" width="30" height="30">
                    <div class="message-bubble p-2 px-3 rounded shadow-sm"
                         style="background-color: var(--link-hover-bg); color: var(--text-color);">
                        Xin chào! Shop có thể hỗ trợ gì cho bạn không ạ?
                    </div>
                </div>
                <div class="message-row d-flex mb-3 flex-row-reverse">
                    <div class="message-bubble p-2 px-3 rounded shadow-sm text-white"
                         style="background-color: var(--primary);">
                        Mình muốn hỏi về phí vận chuyển.
                    </div>
                </div>
                @endfor
            </div>

            {{-- FOOTER INPUT (CỐ ĐỊNH) --}}
            <div class="chat-input-area p-3 border-top flex-shrink-0"
                 style="background: var(--popup-bg); border-color: var(--popup-border) !important; z-index: 5;">
                <div class="input-group">
                    <input type="text"
                           class="form-control border-end-0"
                           placeholder="Nhập câu hỏi của bạn..."
                           style="background-color: var(--bg-body); color: var(--text-color); border-color: var(--popup-border);">

                    <button class="btn btn-outline-secondary border-start-0 text-primary"
                            style="background-color: var(--bg-body); border-color: var(--popup-border);">
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
