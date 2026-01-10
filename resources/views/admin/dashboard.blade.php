@extends('admin.layouts.master') {{-- ĐÃ SỬA: Trỏ vào admin.layouts.master --}}

@section('title', 'Tổng quan Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2 border-0 border-start border-4 border-primary">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Doanh thu (Tháng)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">40.000.000đ</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2 border-0 border-start border-4 border-success">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Đơn hàng mới</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
