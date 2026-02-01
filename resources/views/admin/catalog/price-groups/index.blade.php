@extends('admin.layouts.master')

@section('title', $title ?? 'Quản lý PriceGroup')

@section('content')
    @include('admin.partials.schema-view')

    {{--
        GEMINI NOTE:
        Đây là giao diện "Hồ sơ thiết kế" (Placeholder).
        Hiện tại chỉ hiển thị thông báo component đang hoạt động.
    --}}

    <livewire:admin.catalog.price-group-table />

@endsection