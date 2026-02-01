@extends('admin.layouts.master')

@section('title', $title ?? 'Quản lý News')

@section('content')
    <livewire:admin.content.news-table />
    <livewire:admin.content.news-modal />
@endsection
