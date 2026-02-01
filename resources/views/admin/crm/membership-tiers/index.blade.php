@extends('admin.layouts.master')

@section('title', $title ?? 'Quản lý MembershipTier')

@section('content')
    <livewire:admin.crm.membership-tier-table />
    <livewire:admin.crm.membership-tier-modal />
@endsection
