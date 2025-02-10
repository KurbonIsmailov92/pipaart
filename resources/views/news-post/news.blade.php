@extends('layouts.app')

@section('title', 'Новости')

@section('content')
    <div class="flex items-center justify-between w-full mb-8">
        <h1 class="mt-6 text-primary text-2xl sm:text-4xl text-center">Новости</h1>
        <x-form.button class="ml-4"><a href="/news/create">Добавить новость</a></x-form.button>
    </div>

    <div class="text-sm sm:text-base mt-6 space-y-6">
        @foreach($newsPosts as $newsPost)
            <x-old-news title="{{ $newsPost->title }}">
                {{ Str::limit($newsPost->text, 200) }}
                <br>
                <br>
                <x-form.button class="mt-3">
                    <a href="{{ route('news.show', $newsPost->id) }}">
                        Читать дальше →
                    </a>
                </x-form.button>
            </x-old-news>
        @endforeach
    </div>
@endsection
