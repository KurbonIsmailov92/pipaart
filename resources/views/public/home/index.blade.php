@extends('layouts.app')

@section('title', $settings['site_name'])

@section('content')
    <x-carousel>
        <x-slot:indicators>
            <x-carousel.indicators :slidesCount="3"/>
        </x-slot:indicators>

        <x-slot:items>
            <x-carousel.item
                image="{{ \Illuminate\Support\Facades\Vite::asset('resources/images/carousel/cap-cipa.jpg') }}"
                title="CAP / CIPA Programs"
                isActive="true"
            />
            <x-carousel.item
                image="{{ \Illuminate\Support\Facades\Vite::asset('resources/images/carousel/success.jpg') }}"
                title="Build your accounting and finance career"
            />
            <x-carousel.item
                image="{{ \Illuminate\Support\Facades\Vite::asset('resources/images/carousel/step.jpg') }}"
                title="Learn through a structured CMS-driven educational platform"
            />
        </x-slot:items>
    </x-carousel>

    <div class="py-1 text-center">
        <h1 class="mt-6 text-2xl font-bold text-blue-950 sm:text-4xl">{{ $settings['hero_title'] }}</h1>
        <p class="text-sm font-bold sm:text-base">{{ $settings['hero_subtitle'] }}</p>
    </div>

    <div class="mt-8 grid grid-cols-1 gap-6 pb-10 text-center sm:grid-cols-2 lg:grid-cols-3">
        @foreach($featuredNews as $newsPost)
            <x-news title="{{ $newsPost->title }}" argc="{{ route('news.show', $newsPost) }}">
                {{ \Illuminate\Support\Str::limit($newsPost->content, 120) }}
            </x-news>
        @endforeach
    </div>

    <x-search/>

    <div class="space-y-6">
        @foreach($archiveNews as $oldNewsPost)
            <x-old-news title="{{ $oldNewsPost->title }}">
                {{ \Illuminate\Support\Str::limit($oldNewsPost->content, 120) }}
                <br>
                <br>
                <x-form.button class="mt-3">
                    <a href="{{ route('news.show', $oldNewsPost) }}">Read more →</a>
                </x-form.button>
            </x-old-news>
        @endforeach
    </div>

    <div class="mt-10 grid gap-6 md:grid-cols-3">
        @foreach($featuredCourses as $course)
            <div class="rounded-2xl bg-white p-5 shadow">
                <h3 class="text-lg font-semibold">{{ $course->title }}</h3>
                <p class="mt-2 text-sm text-gray-600">{{ $course->duration }}</p>
                <p class="mt-2 text-sm text-gray-600">{{ number_format((float) $course->price, 2) }}</p>
                <a href="{{ route('courses.show', $course) }}" class="mt-4 inline-flex rounded-xl bg-slate-900 px-4 py-2 text-sm text-white">Open course</a>
            </div>
        @endforeach
    </div>

    <div class="mt-6 flex flex-auto items-center justify-center">
        <x-form.button>
            <a href="{{ route('news.list') }}">All news</a>
        </x-form.button>
    </div>
@endsection
