@extends('admin.layouts.master')

@section('title', $title ?? 'Quản lý RewardHistory')

@section('content')
    @include('admin.partials.schema-view')

    <livewire:admin.finance.reward-history-table />
    <livewire:admin.finance.reward-history-modal />
@endsection
