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
                title="РњР•Р–Р”РЈРќРђР РћР”РќРђРЇ РџР РћР¤Р•РЎРЎРРћРќРђР›Р¬РќРђРЇ РЎР•Р РўРР¤РРљРђР¦РРЇ Р‘РЈРҐР“РђР›РўР•Р РћР’ РЎРђР /CIPA"
                isActive="true"
            />
            <x-carousel.item
                image="{{ \Illuminate\Support\Facades\Vite::asset('resources/images/carousel/success.jpg') }}"
                title="РџР РРЁР›Рћ Р’Р Р•РњРЇ Р”Р›РЇ Р’РђРЁР•Р“Рћ РљРђР Р¬Р•Р РќРћР“Рћ Р РћРЎРўРђ"
            />
            <x-carousel.item
                image="{{ \Illuminate\Support\Facades\Vite::asset('resources/images/carousel/step.jpg') }}"
                title="Р’Р•Р РќР«Р™ РЁРђР“ РЎР•Р“РћР”РќРЇ - Р¤РЈРќР”РђРњР•РќРў РўР’РћР•Р“Рћ РЈРЎРџР•РҐРђ Р—РђР’РўР Рђ!"
            />
        </x-slot:items>
    </x-carousel>

    <div class="py-1 text-center">
        <h1 class="mt-6 text-2xl font-bold text-blue-950 sm:text-4xl">Р”РѕР±СЂРѕ РїРѕР¶Р°Р»РѕРІР°С‚СЊ РІ {{ $settings['site_name'] }}</h1>
        <p class="text-sm font-bold sm:text-base">Р’Р°С€ РІРµСЂРЅС‹Р№ РїР°СЂС‚РЅРµСЂ РІ РјРёСЂРµ Р±СѓС…РіР°Р»С‚РµСЂСЃРєРѕРіРѕ Рё С„РёРЅР°РЅСЃРѕРІРѕРіРѕ СѓС‡РµС‚Р°.</p>
    </div>

    <div class="mt-8 grid grid-cols-1 gap-6 pb-10 text-center sm:grid-cols-2 lg:grid-cols-3">
        @foreach($featuredNews as $newsPost)
            <x-news title="{{ $newsPost->title }}" argc="{{ route('news.show', $newsPost) }}">
                {{ \Illuminate\Support\Str::limit($newsPost->text, 120) }}
            </x-news>
        @endforeach
    </div>

    <x-search/>

    <div class="space-y-6">
        @foreach($archiveNews as $oldNewsPost)
            <x-old-news title="{{ $oldNewsPost->title }}">
                {{ \Illuminate\Support\Str::limit($oldNewsPost->text, 120) }}
                <br>
                <br>
                <x-form.button class="mt-3">
                    <a href="{{ route('news.show', $oldNewsPost) }}">
                        Р§РёС‚Р°С‚СЊ РґР°Р»СЊС€Рµ →
                    </a>
                </x-form.button>
            </x-old-news>
        @endforeach
    </div>

    <div class="mt-6 flex flex-auto items-center justify-center">
        <x-form.button>
            <a href="{{ route('news.list') }}">Р’СЃРµ РЅРѕРІРѕСЃС‚Рё</a>
        </x-form.button>
    </div>
@endsection
