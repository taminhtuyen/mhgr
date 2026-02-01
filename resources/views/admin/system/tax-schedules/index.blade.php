@extends('admin.layouts.master')

@section('title', $title ?? 'Quản lý TaxSchedule')

@section('content')
    <livewire:admin.system.tax-schedule-table />
    <livewire:admin.system.tax-schedule-modal />
@endsection
