<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản trị Admin - {{ $title ?? 'Trang chủ' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background: #343a40; color: white; padding-top: 20px; }
        .sidebar a { color: #adb5bd; text-decoration: none; display: block; padding: 10px 20px; }
        .sidebar a:hover { background: #495057; color: white; }
        .sidebar .group-title { text-transform: uppercase; font-size: 0.8rem; padding: 20px 20px 5px; color: #6c757d; font-weight: bold; }
        .main-content { padding: 20px; }
        .table-comment { color: #0d6efd; font-style: italic; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 sidebar">
            <h3 class="text-center mb-4">MY ADMIN</h3>

            <div class="group-title">BÁN HÀNG</div>
            <a href="{{ route('admin.orders.index') }}">Đơn hàng</a>
            <a href="{{ route('admin.deliveries.index') }}">Vận chuyển</a>
            <a href="{{ route('admin.returns.index') }}">Trả hàng</a>
            <a href="{{ route('admin.invoices.index') }}">Hóa đơn VAT</a>

            <div class="group-title">SẢN PHẨM</div>
            <a href="{{ route('admin.products.index') }}">Sản phẩm</a>
            <a href="{{ route('admin.categories.index') }}">Danh mục</a>
            <a href="{{ route('admin.attributes.index') }}">Thuộc tính</a>
            <a href="{{ route('admin.suppliers.index') }}">Nhà cung cấp</a>
            <a href="{{ route('admin.reviews.index') }}">Đánh giá</a>

            <div class="group-title">KHO HÀNG</div>
            <a href="{{ route('admin.stocks.index') }}">Tồn kho</a>
            <a href="{{ route('admin.warehouses.index') }}">Kho bãi</a>
            <a href="{{ route('admin.purchase_orders.index') }}">Nhập hàng</a>

            <div class="group-title">KÝ GỬI</div>
            <a href="{{ route('admin.consignment.orders.index') }}">Phiếu ký gửi</a>
            <a href="{{ route('admin.consignment.customers.index') }}">Khách ký gửi</a>

            <div class="group-title">MARKETING</div>
            <a href="{{ route('admin.promotions.index') }}">Chiến dịch</a>
            <a href="{{ route('admin.coupons.index') }}">Mã giảm giá</a>
            <a href="{{ route('admin.flash_sales.index') }}">Flash Sale</a>
            <a href="{{ route('admin.affiliate.index') }}">Tiếp thị liên kết</a>

            <div class="group-title">KHÁCH HÀNG (CRM)</div>
            <a href="{{ route('admin.customers.index') }}">Khách hàng</a>
            <a href="{{ route('admin.chat.index') }}">Hội thoại Chat</a>

            <div class="group-title">HỆ THỐNG</div>
            <a href="{{ route('admin.settings.index') }}">Cài đặt chung</a>
            <a href="{{ route('admin.users.index') }}">Nhân viên</a>
            <a href="{{ route('admin.roles.index') }}">Phân quyền</a>
            <a href="{{ route('admin.locations.index') }}">Địa chính</a>
        </div>

        <div class="col-md-10 main-content">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ $title }}</h5>
                </div>
                <div class="card-body">
                    <p>Dữ liệu từ bảng: <code>{{ $table }}</code></p>

                    @if(empty($columns))
                    <div class="alert alert-danger">Không tìm thấy bảng hoặc bảng chưa được tạo.</div>
                    @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                            <tr>
                                <th>Tên Cột (Field)</th>
                                <th>Kiểu dữ liệu (Type)</th>
                                <th>Mục đích / Ý nghĩa (Comment)</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($columns as $col)
                            <tr>
                                <td><strong>{{ $col->Field }}</strong></td>
                                <td>{{ $col->Type }}</td>
                                <td class="table-comment">{{ $col->Comment ?: '---' }}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
