@extends('layouts.app')

@section('title', 'PIPAART')

@section('content')

    <x-carousel>
        <x-slot:indicators>
            <x-carousel.indicators :slidesCount="3"/>
        </x-slot:indicators>

        <x-slot:items>
            <x-carousel.item
                image="{{ \Illuminate\Support\Facades\Vite::asset('resources/images/carousel/cap-cipa.jpg') }}"
                title="МЕЖДУНАРОДНАЯ ПРОФЕССИОНАЛЬНАЯ СЕРТИФИКАЦИЯ БУХГАЛТЕРОВ САР/CIPA"
                isActive="true"
            />
            <x-carousel.item
                image="{{ \Illuminate\Support\Facades\Vite::asset('resources/images/carousel/success.jpg') }}"
                title="ПРИШЛО ВРЕМЯ ДЛЯ ВАШЕГО КАРЬЕРНОГО РОСТА"
            />
            <x-carousel.item
                image="{{ \Illuminate\Support\Facades\Vite::asset('resources/images/carousel/step.jpg') }}"
                title="ВЕРНЫЙ ШАГ СЕГОДНЯ - ФУНДАМЕНТ ТВОЕГО УСПЕХА ЗАВТРА!"
            />
        </x-slot:items>

    </x-carousel>

    <div class="text-center py-1">
        <h1 class="mt-6 text-primary text-2xl sm:text-4xl text-blue-950 font-bold">Добро пожаловать в PIPAART</h1>
        <p class="text-sm sm:text-base font-bold">Ваш верный партнер в мире бухгалтерского и финансового учета.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-8 text-center pb-10">
        @foreach($newsPosts as $newsPost)
            <x-news title="{{ $newsPost->title }}" argc="{{ route('news.show', $newsPost->id) }}">
                {{ Str::limit($newsPost->text, 120) }}
            </x-news>
        @endforeach
    </div>

    <x-search/>

    <div class="space-y-6">
        @foreach($oldNewsPosts as $oldNewsPost)
            <x-old-news title="{{ $oldNewsPost->title }}">
                {{ Str::limit($oldNewsPost->text, 120) }}
                <br>
                <br>
                <x-form.button class="mt-3">
                    <a href="{{ route('news.show', $oldNewsPost->id) }}">
                        Читать дальше →
                    </a>
                </x-form.button>
            </x-old-news>
        @endforeach
    </div>

    <div class="flex flex-auto items-center justify-center mt-6">
        <x-form.button>
            <a href="{{ route('news.list')}}"> Все новости </a>
        </x-form.button>
    </div>
@endsection
