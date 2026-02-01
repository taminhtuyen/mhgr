@extends('admin.layouts.master')

@section('title', $title ?? 'Quản lý ReviewRatingRule')

@section('content')
    @include('admin.partials.schema-view')

    <livewire:admin.finance.review-rating-rule-table />
    <livewire:admin.finance.review-rating-rule-modal />
@endsection
