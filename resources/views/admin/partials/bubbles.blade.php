<div id="bubble-wrapper" style="position: fixed; bottom: 40px; right: 40px; z-index: 10000;">
    {{-- CÁC BONG BÓNG CON (SUB-BUBBLES) --}}
    {{-- Mặc định ẩn, JS sẽ xử lý hiệu ứng bung ra --}}
    <div class="sub-bubbles-container">

        {{-- Nút 1: Lên đầu trang --}}
        <div class="sub-bubble" id="btn-scroll-top" title="Lên đầu trang">
            <i class="fa-solid fa-arrow-up"></i>
        </div>

        {{-- Nút 2: Mở Chat --}}
        <div class="sub-bubble" id="btn-open-chat" title="Tin nhắn">
            <i class="fa-solid fa-comments"></i>
            {{-- Ví dụ thông báo chưa đọc --}}
            <span class="badge-counter">3</span>
        </div>

        {{-- Nút 3: Xuống cuối trang --}}
        <div class="sub-bubble" id="btn-scroll-bottom" title="Xuống cuối trang">
            <i class="fa-solid fa-arrow-down"></i>
        </div>
    </div>

    {{-- BONG BÓNG CHÍNH (MAIN BUBBLE) --}}
    <div id="nav-bubble" title="Menu">
        <i class="fa-solid fa-bars" id="bubble-icon"></i>
    </div>
</div>
