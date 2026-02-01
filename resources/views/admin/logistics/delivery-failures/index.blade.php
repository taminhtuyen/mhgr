@extends('admin.layouts.master')

@section('title', $title ?? 'Quản lý DeliveryFailure')

@section('content')
    <livewire:admin.logistics.delivery-failure-table />
    <livewire:admin.logistics.delivery-failure-modal />
@endsection
