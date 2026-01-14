{{-- [FIX] Xóa h-100 --}}
<div id="chat-interface" class="d-none">
    <div class="chat-layout h-100 d-flex overflow-hidden">

        {{-- DANH SÁCH CUỘC TRÒ CHUYỆN (SIDEBAR) --}}
        <div class="chat-sidebar d-flex flex-column border-end" id="chat-list-col">
            <div class="p-3 border-bottom">
                <input type="text" class="form-control rounded-pill" placeholder="Tìm kiếm tin nhắn...">
            </div>
            <div class="chat-list flex-grow-1 overflow-auto custom-scrollbar">
                {{-- Mockup Items --}}
                <div class="chat-item p-3 d-flex align-items-center cursor-pointer active" onclick="openChat(1)">
                    <img src="https://ui-avatars.com/api/?name=Admin+A&background=random" class="rounded-circle me-2" width="40" height="40">
                    <div class="flex-grow-1 overflow-hidden">
                        <div class="d-flex justify-content-between">
                            <strong class="text-truncate">Nguyễn Văn A</strong>
                            <small class="text-muted">12:05</small>
                        </div>
                        <div class="text-muted text-truncate small">Đơn hàng của tôi đang ở đâu rồi?</div>
                    </div>
                </div>
                {{-- Mockup Items khác... --}}
            </div>
        </div>

        {{-- NỘI DUNG CUỘC TRÒ CHUYỆN (MAIN) --}}
        <div class="chat-window flex-grow-1 d-flex flex-column" id="chat-content-col">
            {{-- Header Chat --}}
            <div class="chat-header p-3 border-bottom d-flex align-items-center bg-glass">
                {{-- [FIX] Nút Back hiện trên iPad/Tablet (d-lg-none) --}}
                <button class="btn btn-sm btn-light me-3 d-lg-none shadow-sm" onclick="backToChatList()">
                    <i class="fa-solid fa-arrow-left text-primary"></i>
                </button>

                <img src="https://ui-avatars.com/api/?name=Admin+A&background=random" class="rounded-circle me-2" width="35" height="35">
                <div>
                    <div class="fw-bold lh-1">Nguyễn Văn A</div>
                    <small class="text-success"><i class="fa-solid fa-circle" style="font-size: 8px;"></i> Online</small>
                </div>
                <div class="ms-auto">
                    <button class="btn btn-sm btn-icon"><i class="fa-solid fa-phone"></i></button>
                    <button class="btn btn-sm btn-icon"><i class="fa-solid fa-video"></i></button>
                    <button class="btn btn-sm btn-icon"><i class="fa-solid fa-circle-info"></i></button>
                </div>
            </div>

            {{-- Body Chat --}}
            <div class="chat-messages flex-grow-1 p-3 overflow-auto custom-scrollbar bg-transparent">
                <div class="message-row d-flex mb-3">
                    <img src="https://ui-avatars.com/api/?name=Admin+A&background=random" class="rounded-circle me-2 mt-1" width="30" height="30">
                    <div class="message-bubble bg-light p-2 px-3 rounded text-dark">
                        Xin chào, tôi có thể giúp gì cho bạn?
                    </div>
                </div>
                {{-- ... --}}
            </div>

            {{-- Input Chat --}}
            <div class="chat-input-area p-3 border-top bg-glass">
                <div class="input-group">
                    <button class="btn btn-light"><i class="fa-solid fa-plus"></i></button>
                    <input type="text" class="form-control" placeholder="Nhập tin nhắn...">
                    <button class="btn btn-primary"><i class="fa-solid fa-paper-plane"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
