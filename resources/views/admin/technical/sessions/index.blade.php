@extends('admin.layouts.master')

@section('title', $title ?? 'Quản lý Session')

@section('content')
    @include('admin.partials.schema-view')

    <livewire:admin.technical.session-table />
    <livewire:admin.technical.session-modal />
@endsection
