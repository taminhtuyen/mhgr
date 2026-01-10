<div class="sidebar-menu">
    <ul class="menu-list">

        <li class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}">
                <i class="icon-dashboard"></i> <span>Tổng quan</span>
            </a>
        </li>

        <li class="menu-header">BÁN HÀNG</li>
        <li class="menu-item">
            <a href="{{ route('admin.orders.index') }}">Đơn hàng</a>
        </li>
        <li class="menu-item">
            <a href="{{ route('admin.deliveries.index') }}">Vận đơn / Giao hàng</a>
        </li>
        <li class="menu-item">
            <a href="{{ route('admin.returns.index') }}">Đổi trả hàng</a>
        </li>
        <li class="menu-item">
            <a href="{{ route('admin.invoices.index') }}">Hóa đơn VAT</a>
        </li>
        <li class="menu-item">
            <a href="{{ route('admin.carts.index') }}">Giỏ hàng treo</a>
        </li>

        <li class="menu-header">SẢN PHẨM</li>
        <li class="menu-item">
            <a href="{{ route('admin.products.index') }}">Tất cả sản phẩm</a>
        </li>
        <li class="menu-item">
            <a href="{{ route('admin.categories.index') }}">Danh mục</a>
        </li>
        <li class="menu-item">
            <a href="{{ route('admin.attributes.index') }}">Thuộc tính (Màu/Size)</a>
        </li>
        <li class="menu-item">
            <a href="{{ route('admin.reviews.index') }}">Đánh giá sản phẩm</a>
        </li>
        <li class="menu-item">
            <a href="{{ route('admin.suppliers.index') }}">Nhà cung cấp</a>
        </li>

        <li class="menu-header">KHO HÀNG</li>
        <li class="menu-item">
            <a href="{{ route('admin.stocks.index') }}">Tồn kho</a>
        </li>
        <li class="menu-item">
            <a href="{{ route('admin.purchase-orders.index') }}">Nhập hàng</a>
        </li>
        <li class="menu-item">
            <a href="{{ route('admin.transactions.index') }}">Lịch sử kho</a>
        </li>
        <li class="menu-item">
            <a href="{{ route('admin.warehouses.index') }}">Kho bãi</a>
        </li>

        <li class="menu-header">KHÁCH HÀNG</li>
        <li class="menu-item">
            <a href="{{ route('admin.customers.index') }}">Danh sách khách hàng</a>
        </li>
        <li class="menu-item">
            <a href="{{ route('admin.chats.index') }}">Hội thoại / Chat</a>
        </li>
        <li class="menu-item">
            <a href="{{ route('admin.requests.index') }}">Yêu cầu & Góp ý</a>
        </li>

        <li class="menu-header">MARKETING</li>
        <li class="menu-item">
            <a href="{{ route('admin.promotions.index') }}">Chiến dịch khuyến mãi</a>
        </li>
        <li class="menu-item">
            <a href="{{ route('admin.coupons.index') }}">Mã giảm giá</a>
        </li>
        <li class="menu-item">
            <a href="{{ route('admin.flash-sales.index') }}">Flash Sale</a>
        </li>
        <li class="menu-item">
            <a href="{{ route('admin.affiliates.index') }}">Tiếp thị liên kết</a>
        </li>

        <li class="menu-header">KÝ GỬI</li>
        <li class="menu-item">
            <a href="{{ route('admin.consignments.index') }}">Danh sách ký gửi</a>
        </li>
        <li class="menu-item">
            <a href="{{ route('admin.consignment_customers.index') }}">Khách ký gửi</a>
        </li>

        <li class="menu-header">NỘI DUNG</li>
        <li class="menu-item">
            <a href="{{ route('admin.posts.index') }}">Tin tức / Bài viết</a>
        </li>
        <li class="menu-item">
            <a href="{{ route('admin.banners.index') }}">Banner quảng cáo</a>
        </li>
        <li class="menu-item">
            <a href="{{ route('admin.menus.index') }}">Quản lý Menu</a>
        </li>
        <li class="menu-item">
            <a href="{{ route('admin.pages.index') }}">Trang tĩnh</a>
        </li>
        <li class="menu-item">
            <a href="{{ route('admin.images.index') }}">Thư viện ảnh</a>
        </li>
        <li class="menu-item">
            <a href="{{ route('admin.game-subjects.index') }}">Game & Chủ đề</a>
        </li>

        <li class="menu-header">TÀI CHÍNH</li>
        <li class="menu-item">
            <a href="{{ route('admin.wallets.index') }}">Ví điện tử</a>
        </li>
        <li class="menu-item">
            <a href="{{ route('admin.profits.index') }}">Phân chia lợi nhuận</a>
        </li>

        <li class="menu-header">HỆ THỐNG</li>
        <li class="menu-item">
            <a href="{{ route('admin.settings.index') }}">Cấu hình hệ thống</a>
        </li>
        <li class="menu-item">
            <a href="{{ route('admin.users.index') }}">Quản trị viên</a>
        </li>
        <li class="menu-item">
            <a href="{{ route('admin.roles.index') }}">Phân quyền & Vai trò</a>
        </li>
        <li class="menu-item">
            <a href="{{ route('admin.locations.index') }}">Tỉnh / Thành phố</a>
        </li>
        <li class="menu-item">
            <a href="{{ route('admin.logs.index') }}">Nhật ký hoạt động</a>
        </li>
    </ul>
</div>
