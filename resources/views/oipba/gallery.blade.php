@extends('layouts.app')

@section('title', 'ОИПБА РТ Фотогалерея')

@section('content')
    <h1 class="mt-6 text-primary text-2xl sm:text-4xl">Фотогалерея</h1>

    <div class="text-sm sm:text-base mt-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-8 text-center">
            @for($i=0; $i<6; $i++)
               <x-gallery-item></x-gallery-item>
            @endfor
        </div>
    </div>

    <x-image-viewer/>

@endsection

