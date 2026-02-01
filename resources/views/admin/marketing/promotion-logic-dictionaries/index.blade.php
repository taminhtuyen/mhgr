@extends('admin.layouts.master')

@section('title', $title ?? 'Quản lý PromotionLogicDictionary')

@section('content')
    <livewire:admin.marketing.promotion-logic-dictionary-table />
    <livewire:admin.marketing.promotion-logic-dictionary-modal />
@endsection
