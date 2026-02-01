@extends('admin.layouts.master')

@section('title', $title ?? 'Quản lý PaymentTransaction')

@section('content')
    @include('admin.partials.schema-view')

    <livewire:admin.finance.payment-transaction-table />
    <livewire:admin.finance.payment-transaction-modal />
@endsection
