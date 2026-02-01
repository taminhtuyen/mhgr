@extends('admin.layouts.master')

@section('title', $title ?? 'Quản lý CategoryCollection')

@section('content')
    @include('admin.partials.schema-view')

    <livewire:admin.catalog.category-collection-table />
    <livewire:admin.catalog.category-collection-modal />
@endsection
