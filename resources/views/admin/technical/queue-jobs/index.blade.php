@extends('admin.layouts.master')

@section('title', $title ?? 'Quản lý QueueJob')

@section('content')
    @include('admin.partials.schema-view')

    <livewire:admin.technical.queue-job-table />
    <livewire:admin.technical.queue-job-modal />
@endsection
