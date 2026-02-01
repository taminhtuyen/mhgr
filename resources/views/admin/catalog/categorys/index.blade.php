@extends('admin.layouts.master')

@section('title', $title ?? 'Quản lý Module')

@section('content')
    @include('admin.partials.schema-view')

    {{--
        GEMINI NOTE:
        Đây là giao diện "Hồ sơ thiết kế".
        Khi bạn sẵn sàng code chức năng thật, hãy xóa dòng @include bên dưới
        và viết code giao diện Livewire/Table vào đây.
    --}}

    <livewire:admin.catalog.category-table />

@endsection