@extends('admin.layouts.master')

@section('title', $title ?? 'Quản lý Packing')

@section('content')
    @include('admin.partials.schema-view')

    <livewire:admin.inventory.packing-table />
    <livewire:admin.inventory.packing-modal />
@endsection
