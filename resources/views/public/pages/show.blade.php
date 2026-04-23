@extends('layouts.app')

@section('title', $page->meta_title ?: $page->title)
@section('meta_description', $page->meta_description ?: '')

@section('content')
    <section class="mx-auto max-w-4xl px-4 py-10">
        <h1 class="text-4xl font-semibold text-slate-900">{{ $page->title }}</h1>
        <div class="prose prose-slate mt-8 max-w-none rounded-2xl bg-white p-8 shadow-sm">
            {!! nl2br(e($page->content)) !!}
        </div>
    </section>
@endsection
