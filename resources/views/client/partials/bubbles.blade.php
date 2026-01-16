<div id="bubble-wrapper" style="position: fixed; bottom: 30px; right: 30px; z-index: 10000;">
    <div class="sub-bubbles-container">
        {{-- Lên đầu trang --}}
        <div class="sub-bubble" id="btn-scroll-top" title="Lên đầu trang">
            <i class="fa-solid fa-arrow-up"></i>
        </div>

        {{-- Nút Chat (Đã đổi icon thành comments để giống Admin) --}}
        <div class="sub-bubble" id="btn-open-chat" title="Tin nhắn">
            <i class="fa-solid fa-comments"></i>
            {{-- Badge đếm số tin nhắn chưa đọc --}}
            <span class="badge-counter">1</span>
        </div>

        {{-- Xuống cuối trang --}}
        <div class="sub-bubble" id="btn-scroll-bottom" title="Xuống cuối trang">
            <i class="fa-solid fa-arrow-down"></i>
        </div>
    </div>

    {{-- Bong bóng chính --}}
    <div id="nav-bubble" title="Menu">
        <i class="fa-solid fa-bars" id="bubble-icon"></i>

        {{-- CHẤM ĐỎ BÁO TIN NHẮN --}}
        <span class="main-bubble-badge"></span>
    </div>
</div>
