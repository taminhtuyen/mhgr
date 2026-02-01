@extends('admin.layouts.master')

@section('title', $title ?? 'Quản lý DeliveryFailure')

@section('content')
    @include('admin.partials.schema-view')

    <livewire:admin.logistics.delivery-failure-table />
    <livewire:admin.logistics.delivery-failure-modal />
@endsection
