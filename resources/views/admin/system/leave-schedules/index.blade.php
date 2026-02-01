@extends('admin.layouts.master')

@section('title', $title ?? 'Quản lý LeaveSchedule')

@section('content')
    @include('admin.partials.schema-view')

    <livewire:admin.system.leave-schedule-table />
    <livewire:admin.system.leave-schedule-modal />
@endsection
