@extends('admin.layouts.master')

@section('title', $title ?? 'Quản lý Content')

@section('content')
    <livewire:admin.content.content-table />
    <livewire:admin.content.content-modal />
@endsection
