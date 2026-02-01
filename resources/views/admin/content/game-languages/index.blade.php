@extends('admin.layouts.master')

@section('title', $title ?? 'Quản lý GameLanguage')

@section('content')
    <livewire:admin.content.game-language-table />
    <livewire:admin.content.game-language-modal />
@endsection
