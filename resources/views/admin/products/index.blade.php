@extends('admin.layouts.master')

@section('title', 'Schema: Sản Phẩm')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
        <div>
            <h1 class="h3 fw-bold text-primary mb-0"><i class="fa-solid fa-database me-2"></i> QUẢN LÝ SẢN PHẨM</h1>
            <p class="text-muted mb-0">Xem trước cấu trúc bảng dữ liệu (Database Schema)</p>
        </div>
        <div>
            <button class="btn btn-secondary btn-sm me-2">Export SQL</button>
            <button class="btn btn-primary btn-sm">Chỉnh sửa Schema</button>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-5">
        <div class="card-header bg-white py-3 border-bottom border-primary border-3">
            <h5 class="m-0 fw-bold text-dark">1. Bảng dữ liệu: <code class="text-primary fs-5">products</code></h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover table-striped mb-0 align-middle">
                <thead class="table-dark">
                <tr>
                    <th width="15%">Tên Cột (Column)</th>
                    <th width="10%">Kiểu (Type)</th>
                    <th width="10%">Bắt buộc?</th>
                    <th width="10%">Mặc định</th>
                    <th>Tác dụng / Mô tả</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="fw-bold text-primary">id</td>
                    <td>BIGINT</td>
                    <td><span class="badge bg-danger">Yes</span></td>
                    <td>Auto Inc</td>
                    <td>Khóa chính (Primary Key), ID duy nhất của sản phẩm.</td>
                </tr>
                <tr>
                    <td class="fw-bold">name</td>
                    <td>VARCHAR(255)</td>
                    <td><span class="badge bg-danger">Yes</span></td>
                    <td>NULL</td>
                    <td>Tên sản phẩm hiển thị ra bên ngoài.</td>
                </tr>
                <tr>
                    <td class="fw-bold">slug</td>
                    <td>VARCHAR(255)</td>
                    <td><span class="badge bg-danger">Yes</span></td>
                    <td>NULL</td>
                    <td>Đường dẫn thân thiện cho SEO (Ví dụ: ao-thun-nam). Unique.</td>
                </tr>
                <tr>
                    <td class="fw-bold">sku</td>
                    <td>VARCHAR(50)</td>
                    <td>No</td>
                    <td>NULL</td>
                    <td>Mã quản lý kho (Stock Keeping Unit).</td>
                </tr>
                <tr>
                    <td class="fw-bold">price</td>
                    <td>DECIMAL(15,2)</td>
                    <td><span class="badge bg-danger">Yes</span></td>
                    <td>0</td>
                    <td>Giá bán lẻ niêm yết.</td>
                </tr>
                <tr>
                    <td class="fw-bold">cost_price</td>
                    <td>DECIMAL(15,2)</td>
                    <td>No</td>
                    <td>0</td>
                    <td>Giá vốn nhập hàng (để tính lợi nhuận, ẩn với khách).</td>
                </tr>
                <tr>
                    <td class="fw-bold">description</td>
                    <td>LONGTEXT</td>
                    <td>No</td>
                    <td>NULL</td>
                    <td>Mô tả chi tiết sản phẩm (Nội dung HTML).</td>
                </tr>
                <tr>
                    <td class="fw-bold">is_active</td>
                    <td>TINYINT</td>
                    <td><span class="badge bg-danger">Yes</span></td>
                    <td>1</td>
                    <td>Trạng thái: 1 (Hiển thị), 0 (Ẩn/Nháp).</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-5">
        <div class="card-header bg-white py-3 border-bottom border-warning border-3">
            <h5 class="m-0 fw-bold text-dark">2. Bảng phụ: <code class="text-warning fs-5">product_images</code></h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-dark">
                <tr>
                    <th width="15%">Tên Cột</th>
                    <th width="10%">Kiểu</th>
                    <th>Tác dụng</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="fw-bold text-primary">id</td>
                    <td>BIGINT</td>
                    <td>Khóa chính.</td>
                </tr>
                <tr>
                    <td class="fw-bold text-danger">product_id</td>
                    <td>BIGINT</td>
                    <td>Khóa ngoại liên kết với bảng <code>products</code>.</td>
                </tr>
                <tr>
                    <td class="fw-bold">path</td>
                    <td>VARCHAR(255)</td>
                    <td>Đường dẫn lưu file ảnh trên server/cloud.</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
