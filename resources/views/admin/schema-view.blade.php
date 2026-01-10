@extends('admin.layouts.master') {{-- ĐÃ SỬA --}}

@section('title', $title ?? 'Danh sách dữ liệu')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center bg-white">
        <h6 class="m-0 font-weight-bold text-primary">{{ $title ?? 'Danh sách' }}</h6>
        <a href="#" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Thêm mới</a>
    </div>
    <div class="card-body">
        @if(isset($schema) && count($schema) > 0)
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead class="table-light">
                <tr>
                    @foreach($schema as $column)
                    <th>
                        {{ $column['name'] }} <br>
                        <span style="font-size: 0.75rem; color: #888; font-weight: normal;">{{ $column['type'] }}</span>
                    </th>
                    @endforeach
                    <th width="100">Hành động</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    @foreach($schema as $column)
                    <td>
                        @if($column['name'] == 'id') 1
                        @elseif(str_contains($column['name'], 'status')) <span class="badge bg-success">Active</span>
                        @else {{ $column['comment'] ? $column['comment'] : '-' }}
                        @endif
                    </td>
                    @endforeach
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-info text-white"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        @else
        <div class="alert alert-warning">
            Chưa có dữ liệu cấu trúc bảng hoặc bảng chưa được tạo trong Database.
        </div>
        @endif
    </div>
</div>
@endsection
