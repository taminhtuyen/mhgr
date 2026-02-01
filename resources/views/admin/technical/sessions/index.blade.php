@extends('admin.layouts.master')

@section('title', $title ?? 'Quản lý Session')

@section('content')
    <livewire:admin.technical.session-table />
    <livewire:admin.technical.session-modal />
@endsection
