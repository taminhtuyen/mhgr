@extends('admin.layouts.master')

@section('title', $title ?? 'Quản lý GameLanguage')

@section('content')
    @include('admin.partials.schema-view')

    <livewire:admin.content.game-language-table />
    <livewire:admin.content.game-language-modal />
@endsection
