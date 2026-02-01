@extends('admin.layouts.master')

@section('title', $title ?? 'Quản lý SearchHistory')

@section('content')
    <livewire:admin.marketing.search-history-table />
    <livewire:admin.marketing.search-history-modal />
@endsection
