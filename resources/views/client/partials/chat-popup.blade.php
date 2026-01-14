<div id="chat-interface" class="d-none">
    <div class="chat-layout h-100 d-flex overflow-hidden">

        {{-- CỘT 1: DANH SÁCH --}}
        <div class="chat-sidebar d-flex flex-column border-end" id="chat-list-col">
            <div class="p-3 border-bottom text-center fw-bold text-primary">
                HỖ TRỢ TRỰC TUYẾN
            </div>
            <div class="chat-list flex-grow-1 overflow-auto custom-scrollbar">
                <div class="chat-item p-3 d-flex align-items-center cursor-pointer active" onclick="openChat(1)">
                    <div class="position-relative">
                        <img src="https://ui-avatars.com/api/?name=Support&background=0ea5e9&color=fff" class="rounded-circle me-2" width="45" height="45">
                        <span class="position-absolute bottom-0 end-0 bg-success border border-white rounded-circle" style="width: 12px; height: 12px;"></span>
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <div class="d-flex justify-content-between">
                            <strong class="text-truncate">Chăm Sóc Khách Hàng</strong>
                        </div>
                        <div class="text-muted text-truncate small">Chúng tôi có thể giúp gì cho bạn?</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- CỘT 2: NỘI DUNG --}}
        <div class="chat-window flex-grow-1 d-flex flex-column" id="chat-content-col">
            {{-- HEADER CHAT --}}
            <div class="chat-header p-3 border-bottom d-flex align-items-center" style="background: var(--popup-bg); backdrop-filter: blur(5px);">

                {{-- [SỬA 1] Thay d-md-none thành d-lg-none --}}
                {{-- Để nút này hiện trên cả Mobile và Tablet (iPad) --}}
                <button class="btn btn-sm btn-light me-3 d-lg-none shadow-sm" onclick="backToChatList()">
                    <i class="fa-solid fa-arrow-left text-primary"></i>
                </button>

                <div class="d-flex align-items-center">
                    {{-- [SỬA 2] Thay d-md-none thành d-lg-none --}}
                    <div class="position-relative d-lg-none me-2">
                        <img src="https://ui-avatars.com/api/?name=Support&background=0ea5e9&color=fff" class="rounded-circle" width="35" height="35">
                    </div>
                    <div>
                        <div class="fw-bold lh-1 text-primary">Chat với Admin</div>
                        {{-- [SỬA 3] Thay d-md-block thành d-lg-block --}}
                        <small class="text-muted d-none d-lg-block" style="font-size: 0.75rem;">Luôn sẵn sàng hỗ trợ</small>
                    </div>
                </div>
            </div>

            {{-- BODY CHAT --}}
            <div class="chat-messages flex-grow-1 p-3 overflow-auto custom-scrollbar bg-transparent">
                <div class="message-row d-flex mb-3">
                    <img src="https://ui-avatars.com/api/?name=Support&background=0ea5e9&color=fff" class="rounded-circle me-2 mt-1" width="30" height="30">
                    <div class="message-bubble bg-light p-2 px-3 rounded text-dark shadow-sm">
                        Xin chào! Shop có thể hỗ trợ gì cho bạn không ạ?
                    </div>
                </div>
            </div>

            {{-- FOOTER --}}
            <div class="chat-input-area p-3 border-top" style="background: var(--popup-bg);">
                <div class="input-group">
                    <input type="text" class="form-control border-end-0" placeholder="Nhập câu hỏi của bạn...">
                    <button class="btn btn-outline-secondary border-start-0 bg-white text-primary"><i class="fa-solid fa-paper-plane"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
