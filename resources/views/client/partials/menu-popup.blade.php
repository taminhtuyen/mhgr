<div class="popup-header d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
    <div class="h5 mb-0 fw-bold" style="color: var(--text-color);">
        <i class="fa-solid fa-compass me-2"></i>MENU KHÁCH HÀNG
    </div>

    {{-- SWITCH BUTTON NGÀY ĐÊM (NEW DESIGN) --}}
    <div class="theme-switch-wrapper">
        <label for="theme" class="theme">
            <span class="theme__toggle-wrap">
                <input id="theme" class="theme__toggle" type="checkbox" role="switch" name="theme" value="dark">
                <span class="theme__icon">
                    <span class="theme__icon-part"></span>
                    <span class="theme__icon-part"></span>
                    <span class="theme__icon-part"></span>
                    <span class="theme__icon-part"></span>
                    <span class="theme__icon-part"></span>
                    <span class="theme__icon-part"></span>
                    <span class="theme__icon-part"></span>
                    <span class="theme__icon-part"></span>
                    <span class="theme__icon-part"></span>
                </span>
            </span>
        </label>
    </div>
</div>

<div class="popup-grid">
    {{-- MENU KHÁM PHÁ --}}
    <div class="menu-column">
        <div class="group-title text-primary">KHÁM PHÁ</div>
        <a href="/" class="menu-link"><i class="fa-solid fa-house"></i> Trang Chủ</a>
        <a href="#" class="menu-link"><i class="fa-solid fa-store"></i> Cửa Hàng</a>
        <a href="#" class="menu-link"><i class="fa-solid fa-fire"></i> Khuyến Mãi Hot</a>
        <a href="#" class="menu-link"><i class="fa-solid fa-newspaper"></i> Tin Tức</a>

        <div class="group-title text-success group-spacer">CÁ NHÂN</div>
        <a href="#" class="menu-link"><i class="fa-solid fa-user"></i> Tài Khoản</a>
        <a href="#" class="menu-link"><i class="fa-solid fa-heart"></i> Yêu Thích</a>
    </div>

    {{-- MENU MUA SẮM --}}
    <div class="menu-column">
        <div class="group-title text-warning">MUA SẮM</div>
        <a href="#" class="menu-link"><i class="fa-solid fa-cart-shopping"></i> Giỏ Hàng <span class="badge bg-danger ms-auto rounded-pill">3</span></a>
        <a href="#" class="menu-link"><i class="fa-solid fa-box"></i> Đơn Mua</a>
        <a href="#" class="menu-link"><i class="fa-solid fa-clock-rotate-left"></i> Lịch Sử Xem</a>

        <div class="group-title text-info group-spacer">HỖ TRỢ</div>
        <a href="#" class="menu-link"><i class="fa-solid fa-circle-question"></i> Trung Tâm Trợ Giúp</a>
        <a href="#" class="menu-link"><i class="fa-solid fa-shield-halved"></i> Chính Sách Bảo Mật</a>
    </div>
</div>
