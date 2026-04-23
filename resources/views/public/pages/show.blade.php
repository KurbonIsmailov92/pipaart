@extends('layouts.app')

@section('title', $page->meta_title ?: $page->title)
@section('meta_description', $page->meta_description ?: '')

@section('content')
    <x-ui.page-header :title="$page->title" :description="$page->meta_description"></x-ui.page-header>

    <x-ui.card class="prose prose-slate max-w-none p-8 sm:p-10">
        {!! nl2br(e($page->content)) !!}
    </x-ui.card>
@endsection
