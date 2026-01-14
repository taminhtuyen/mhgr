@extends('client.layouts.master')

@section('title', 'Trang Chủ - Cửa Hàng Trực Tuyến')

@section('content')

{{-- 1. HEADER ĐƠN GIẢN --}}
<header class="d-flex justify-content-between align-items-center py-3 mb-4 border-bottom">
    <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
        <span class="fs-4 fw-bold text-primary"><i class="fa-solid fa-store me-2"></i>MY SHOP</span>
    </a>
    <div class="d-flex align-items-center gap-3">
        <div class="input-group d-none d-md-flex" style="width: 300px;">
            <input type="text" class="form-control" placeholder="Tìm kiếm sản phẩm...">
            <button class="btn btn-outline-primary"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
        <a href="#" class="btn btn-primary rounded-pill position-relative">
            <i class="fa-solid fa-cart-shopping"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
        </a>
    </div>
</header>

{{-- 2. BANNER HERO --}}
<div class="p-5 mb-4 bg-light rounded-3 shadow-sm" style="background: linear-gradient(135deg, #0ea5e9 0%, #3b82f6 100%); color: white;">
    <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold">Siêu Sale Mùa Hè</h1>
        <p class="col-md-8 fs-4">Giảm giá lên đến 50% cho tất cả các mặt hàng thời trang và công nghệ. Miễn phí vận chuyển cho đơn từ 500k.</p>
        <button class="btn btn-light btn-lg text-primary fw-bold" type="button">Mua Ngay</button>
    </div>
</div>

{{-- 3. DANH MỤC NỔI BẬT --}}
<div class="mb-5">
    <h3 class="fw-bold mb-3 border-start border-4 border-primary ps-3">Danh Mục</h3>
    <div class="row row-cols-2 row-cols-md-4 g-4">
        @foreach(['Điện Thoại', 'Laptop', 'Thời Trang', 'Phụ Kiện'] as $cat)
        <div class="col">
            <div class="card h-100 text-center border-0 shadow-sm hover-shadow transition">
                <div class="card-body py-4">
                    <div class="rounded-circle bg-primary bg-opacity-10 mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="fa-solid fa-layer-group text-primary fs-4"></i>
                    </div>
                    <h5 class="card-title mb-0">{{ $cat }}</h5>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- 4. SẢN PHẨM MỚI (Grid dài để test scroll) --}}
<div class="mb-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold border-start border-4 border-warning ps-3">Sản Phẩm Mới</h3>
        <a href="#" class="text-decoration-none">Xem tất cả <i class="fa-solid fa-arrow-right"></i></a>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
        {{-- Loop giả lập 12 sản phẩm --}}
        @for($i = 1; $i <= 12; $i++)
        <div class="col">
            <div class="card h-100 border-0 shadow-sm">
                {{-- Ảnh giả --}}
                <div style="height: 200px; background-color: #e2e8f0;" class="d-flex align-items-center justify-content-center text-muted">
                    IMG PRODUCT {{ $i }}
                </div>
                <div class="card-body">
                    <h5 class="card-title text-truncate">Sản phẩm Demo Số {{ $i }}</h5>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-danger">{{ number_format(100000 + ($i * 50000)) }}đ</span>
                        <small class="text-decoration-line-through text-muted">999.000đ</small>
                    </div>
                </div>
                <div class="card-footer bg-white border-top-0 d-grid">
                    <button class="btn btn-outline-primary btn-sm"><i class="fa-solid fa-cart-plus"></i> Thêm vào giỏ</button>
                </div>
            </div>
        </div>
        @endfor
    </div>
</div>

{{-- 5. FOOTER --}}
<footer class="pt-5 mt-5 border-top text-muted">
    <div class="row">
        <div class="col-6 col-md-3 mb-3">
            <h5>Hỗ trợ</h5>
            <ul class="nav flex-column">
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Trung tâm trợ giúp</a></li>
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Hướng dẫn mua hàng</a></li>
            </ul>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <h5>Về chúng tôi</h5>
            <ul class="nav flex-column">
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Giới thiệu</a></li>
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Tuyển dụng</a></li>
            </ul>
        </div>
        <div class="col-md-5 offset-md-1 mb-3">
            <form>
                <h5>Đăng ký nhận tin</h5>
                <p>Nhận thông báo về các sản phẩm mới và ưu đãi đặc biệt.</p>
                <div class="d-flex flex-column flex-sm-row w-100 gap-2">
                    <input type="text" class="form-control" placeholder="Địa chỉ Email">
                    <button class="btn btn-primary" type="button">Đăng ký</button>
                </div>
            </form>
        </div>
    </div>
</footer>

{{-- CSS Bổ sung cho trang chủ --}}
<style>
    .hover-shadow:hover { transform: translateY(-5px); box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important; }
    .transition { transition: all 0.3s ease; }
</style>
@endsection
