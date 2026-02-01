@extends('admin.layouts.master')

@section('title', $title ?? 'Quản lý Pulse')

@section('content')
    <livewire:admin.technical.pulse-table />
    <livewire:admin.technical.pulse-modal />
@endsection
