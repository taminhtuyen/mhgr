@extends('admin.layouts.master')

@section('title', $title ?? 'Quản lý CategoryCollection')

@section('content')
    <livewire:admin.catalog.category-collection-table />
    <livewire:admin.catalog.category-collection-modal />
@endsection
