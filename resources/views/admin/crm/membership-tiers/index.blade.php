@extends('admin.layouts.master')

@section('title', $title ?? 'Quản lý MembershipTier')

@section('content')
    @include('admin.partials.schema-view')

    <livewire:admin.crm.membership-tier-table />
    <livewire:admin.crm.membership-tier-modal />
@endsection
