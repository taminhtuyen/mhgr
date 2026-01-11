<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Quản Trị' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f9; }
        .sidebar { min-height: 100vh; background-color: #343a40; color: #fff; }
        .sidebar a { color: #cfd8dc; text-decoration: none; padding: 10px 15px; display: block; font-size: 0.95rem; }
        .sidebar a:hover { background-color: #495057; color: #fff; }
        .sidebar a.active { background-color: #0d6efd; color: #fff; font-weight: bold; }
        .sidebar .section-title { font-size: 0.75rem; text-transform: uppercase; color: #adb5bd; padding: 15px 15px 5px; font-weight: bold; letter-spacing: 0.5px; }
        .main-content { padding: 20px; }
        .card { box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); border: none; }
        .table th { background-color: #f8f9fa; font-weight: 600; font-size: 0.9rem; }
        .table td { vertical-align: middle; font-size: 0.9rem; }
    </style>
</head>
<body>

<div class="d-flex">
    <div class="sidebar flex-shrink-0 p-3" style="width: 260px;">
        <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <span class="fs-4 fw-bold"><i class="fa-solid fa-shield-halved me-2"></i>Admin Panel</span>
        </a>
        <hr>

        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-gauge-high me-2 w-20"></i> Tổng Quan
        </a>

        <div class="section-title">Bán Hàng</div>
        <a href="{{ route('admin.sales.orders.index') }}" class="{{ request()->routeIs('admin.sales.orders.*') ? 'active' : '' }}"><i class="fa-solid fa-cart-shopping me-2 w-20"></i> Đơn Hàng</a>
        <a href="{{ route('admin.sales.deliveries.index') }}" class="{{ request()->routeIs('admin.sales.deliveries.*') ? 'active' : '' }}"><i class="fa-solid fa-truck me-2 w-20"></i> Vận Chuyển</a>
        <a href="{{ route('admin.sales.returns.index') }}" class="{{ request()->routeIs('admin.sales.returns.*') ? 'active' : '' }}"><i class="fa-solid fa-rotate-left me-2 w-20"></i> Trả Hàng</a>
        <a href="{{ route('admin.sales.invoices.index') }}" class="{{ request()->routeIs('admin.sales.invoices.*') ? 'active' : '' }}"><i class="fa-solid fa-file-invoice me-2 w-20"></i> Hóa Đơn</a>
        <a href="{{ route('admin.sales.carts.index') }}" class="{{ request()->routeIs('admin.sales.carts.*') ? 'active' : '' }}"><i class="fa-solid fa-cart-arrow-down me-2 w-20"></i> Giỏ Hàng Treo</a>

        <div class="section-title">Sản Phẩm</div>
        <a href="{{ route('admin.catalog.products.index') }}" class="{{ request()->routeIs('admin.catalog.products.*') ? 'active' : '' }}"><i class="fa-solid fa-box-open me-2 w-20"></i> Danh Sách SP</a>
        <a href="{{ route('admin.catalog.categories.index') }}" class="{{ request()->routeIs('admin.catalog.categories.*') ? 'active' : '' }}"><i class="fa-solid fa-layer-group me-2 w-20"></i> Danh Mục</a>
        <a href="{{ route('admin.catalog.attributes.index') }}" class="{{ request()->routeIs('admin.catalog.attributes.*') ? 'active' : '' }}"><i class="fa-solid fa-tags me-2 w-20"></i> Thuộc Tính</a>
        <a href="{{ route('admin.catalog.suppliers.index') }}" class="{{ request()->routeIs('admin.catalog.suppliers.*') ? 'active' : '' }}"><i class="fa-solid fa-handshake me-2 w-20"></i> Nhà Cung Cấp</a>
        <a href="{{ route('admin.catalog.reviews.index') }}" class="{{ request()->routeIs('admin.catalog.reviews.*') ? 'active' : '' }}"><i class="fa-solid fa-star me-2 w-20"></i> Đánh Giá</a>

        <div class="section-title">Kho Hàng</div>
        <a href="{{ route('admin.inventory.stocks.index') }}" class="{{ request()->routeIs('admin.inventory.stocks.*') ? 'active' : '' }}"><i class="fa-solid fa-cubes me-2 w-20"></i> Tồn Kho</a>
        <a href="{{ route('admin.inventory.warehouses.index') }}" class="{{ request()->routeIs('admin.inventory.warehouses.*') ? 'active' : '' }}"><i class="fa-solid fa-warehouse me-2 w-20"></i> Danh Sách Kho</a>
        <a href="{{ route('admin.inventory.purchase-orders.index') }}" class="{{ request()->routeIs('admin.inventory.purchase-orders.*') ? 'active' : '' }}"><i class="fa-solid fa-file-import me-2 w-20"></i> Nhập Hàng (PO)</a>
        <a href="{{ route('admin.inventory.transactions.index') }}" class="{{ request()->routeIs('admin.inventory.transactions.*') ? 'active' : '' }}"><i class="fa-solid fa-clock-rotate-left me-2 w-20"></i> Lịch Sử Kho</a>

        <div class="section-title text-warning">Tài Chính</div>
        <a href="{{ route('admin.finance.profits.index') }}" class="{{ request()->routeIs('admin.finance.profits.*') ? 'active' : '' }}"><i class="fa-solid fa-percent me-2 w-20"></i> Chia Lợi Nhuận</a>
        <a href="{{ route('admin.finance.wallets.index') }}" class="{{ request()->routeIs('admin.finance.wallets.*') ? 'active' : '' }}"><i class="fa-solid fa-wallet me-2 w-20"></i> Ví Tiền</a>
        <a href="{{ route('admin.finance.commissions.index') }}" class="{{ request()->routeIs('admin.finance.commissions.*') ? 'active' : '' }}"><i class="fa-solid fa-money-bill-transfer me-2 w-20"></i> Hoa Hồng</a>

        <div class="section-title">Ký Gửi</div>
        <a href="{{ route('admin.consignment.orders.index') }}" class="{{ request()->routeIs('admin.consignment.orders.*') ? 'active' : '' }}"><i class="fa-solid fa-clipboard-list me-2 w-20"></i> Đơn Ký Gửi</a>
        <a href="{{ route('admin.consignment.customers.index') }}" class="{{ request()->routeIs('admin.consignment.customers.*') ? 'active' : '' }}"><i class="fa-solid fa-users-rectangle me-2 w-20"></i> Khách Ký Gửi</a>

        <div class="section-title">Marketing</div>
        <a href="{{ route('admin.marketing.promotions.index') }}" class="{{ request()->routeIs('admin.marketing.promotions.*') ? 'active' : '' }}"><i class="fa-solid fa-bullhorn me-2 w-20"></i> Chiến Dịch</a>
        <a href="{{ route('admin.marketing.coupons.index') }}" class="{{ request()->routeIs('admin.marketing.coupons.*') ? 'active' : '' }}"><i class="fa-solid fa-ticket me-2 w-20"></i> Mã Giảm Giá</a>
        <a href="{{ route('admin.marketing.flash-sales.index') }}" class="{{ request()->routeIs('admin.marketing.flash-sales.*') ? 'active' : '' }}"><i class="fa-solid fa-bolt me-2 w-20"></i> Flash Sale</a>
        <a href="{{ route('admin.marketing.affiliates.index') }}" class="{{ request()->routeIs('admin.marketing.affiliates.*') ? 'active' : '' }}"><i class="fa-solid fa-network-wired me-2 w-20"></i> Affiliate</a>

        <div class="section-title text-info">Nội Dung</div>
        <a href="{{ route('admin.content.posts.index') }}" class="{{ request()->routeIs('admin.content.posts.*') ? 'active' : '' }}"><i class="fa-solid fa-newspaper me-2 w-20"></i> Tin Tức</a>
        <a href="{{ route('admin.content.banners.index') }}" class="{{ request()->routeIs('admin.content.banners.*') ? 'active' : '' }}"><i class="fa-solid fa-image me-2 w-20"></i> Banner</a>
        <a href="{{ route('admin.content.menus.index') }}" class="{{ request()->routeIs('admin.content.menus.*') ? 'active' : '' }}"><i class="fa-solid fa-bars me-2 w-20"></i> Menu</a>
        <a href="{{ route('admin.content.pages.index') }}" class="{{ request()->routeIs('admin.content.pages.*') ? 'active' : '' }}"><i class="fa-solid fa-file-lines me-2 w-20"></i> Trang Tĩnh</a>
        <a href="{{ route('admin.content.images.index') }}" class="{{ request()->routeIs('admin.content.images.*') ? 'active' : '' }}"><i class="fa-solid fa-images me-2 w-20"></i> Thư Viện Ảnh</a>
        <a href="{{ route('admin.content.game-subjects.index') }}" class="{{ request()->routeIs('admin.content.game-subjects.*') ? 'active' : '' }}"><i class="fa-solid fa-gamepad me-2 w-20"></i> Game / Học Tập</a>

        <div class="section-title">CRM</div>
        <a href="{{ route('admin.crm.customers.index') }}" class="{{ request()->routeIs('admin.crm.customers.*') ? 'active' : '' }}"><i class="fa-solid fa-user-group me-2 w-20"></i> Khách Hàng</a>
        <a href="{{ route('admin.crm.chats.index') }}" class="{{ request()->routeIs('admin.crm.chats.*') ? 'active' : '' }}"><i class="fa-solid fa-comments me-2 w-20"></i> Hội Thoại</a>
        <a href="{{ route('admin.crm.requests.index') }}" class="{{ request()->routeIs('admin.crm.requests.*') ? 'active' : '' }}"><i class="fa-solid fa-envelope-open-text me-2 w-20"></i> Yêu Cầu & Góp Ý</a>

        <div class="section-title">Hệ Thống</div>
        <a href="{{ route('admin.system.settings.index') }}" class="{{ request()->routeIs('admin.system.settings.*') ? 'active' : '' }}"><i class="fa-solid fa-gear me-2 w-20"></i> Cài Đặt</a>
        <a href="{{ route('admin.system.users.index') }}" class="{{ request()->routeIs('admin.system.users.*') ? 'active' : '' }}"><i class="fa-solid fa-user-shield me-2 w-20"></i> Quản Trị Viên</a>
        <a href="{{ route('admin.system.roles.index') }}" class="{{ request()->routeIs('admin.system.roles.*') ? 'active' : '' }}"><i class="fa-solid fa-user-lock me-2 w-20"></i> Phân Quyền</a>
        <a href="{{ route('admin.system.locations.index') }}" class="{{ request()->routeIs('admin.system.locations.*') ? 'active' : '' }}"><i class="fa-solid fa-map-location-dot me-2 w-20"></i> Vị Trí</a>
        <a href="{{ route('admin.system.logs.index') }}" class="{{ request()->routeIs('admin.system.logs.*') ? 'active' : '' }}"><i class="fa-solid fa-terminal me-2 w-20"></i> Logs</a>

        <div class="mt-5 mb-5"></div>
    </div>

    <div class="flex-grow-1 bg-light">
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom px-4">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1">{{ $title ?? 'Trang Quản Trị' }}</span>
                <div class="ms-auto">
                    <button class="btn btn-outline-secondary btn-sm me-2">Thông Báo</button>
                    <button class="btn btn-primary btn-sm">Tài Khoản</button>
                </div>
            </div>
        </nav>

        <div class="main-content">
            @if(isset($table))
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 text-primary fw-bold">Dữ liệu bảng: <span class="text-dark font-monospace">{{ $table }}</span></h5>
                    <button class="btn btn-success btn-sm"><i class="fa-solid fa-plus me-1"></i> Thêm Mới</button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0" style="min-width: 800px;">
                            <thead class="table-light">
                            <tr>
                                @forelse($columns as $col)
                                <th class="text-nowrap" style="min-width: 150px;">
                                    {{ $col->Field }}
                                    @if(!empty($col->Comment))
                                    <div class="small text-muted fw-normal" style="font-size: 0.75rem;">
                                        {{ $col->Comment }}
                                    </div>
                                    @endif
                                </th>
                                @empty
                                <th>Thông báo</th>
                                @endforelse
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                @forelse($columns as $col)
                                <td><span class="text-muted fst-italic">Data...</span></td>
                                @empty
                                <td class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-database fa-2x mb-3 d-block"></i>
                                    Chưa có dữ liệu hoặc cấu trúc bảng hiển thị
                                </td>
                                @endforelse
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <small class="text-muted">Đang hiển thị cấu trúc bảng (Schema View). Dữ liệu thực tế sẽ được tải sau.</small>
                </div>
            </div>
            @else
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card text-white bg-primary h-100">
                        <div class="card-body">
                            <h5 class="card-title">Đơn Hàng</h5>
                            <p class="card-text display-6">120</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card text-white bg-success h-100">
                        <div class="card-body">
                            <h5 class="card-title">Doanh Thu</h5>
                            <p class="card-text display-6">50M</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card text-white bg-warning h-100 text-dark">
                        <div class="card-body">
                            <h5 class="card-title">Thành Viên</h5>
                            <p class="card-text display-6">350</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card text-white bg-danger h-100">
                        <div class="card-body">
                            <h5 class="card-title">Cảnh Báo Kho</h5>
                            <p class="card-text display-6">5</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
