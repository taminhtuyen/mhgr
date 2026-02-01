@extends('admin.layouts.master')

@section('title', $title ?? 'Quản lý ReviewRatingRule')

@section('content')
    <livewire:admin.finance.review-rating-rule-table />
    <livewire:admin.finance.review-rating-rule-modal />
@endsection
