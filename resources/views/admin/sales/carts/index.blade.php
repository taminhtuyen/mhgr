@extends('admin.layouts.master')

@section('title', 'Quản lý Cart')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản lý Cart</h1>
        <a href="#" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm mới
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách Cart (Sales)</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên / Tiêu đề</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th class="text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Dữ liệu sẽ được loop tại đây --}}
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Chưa có dữ liệu Cart
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Phân trang (Pagination) --}}
            <div class="d-flex justify-content-end mt-3">
                {{-- {{ $items->links() }} --}}
            </div>
        </div>
    </div>
</div>
@endsection