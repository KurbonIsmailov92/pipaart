@extends('layouts.app')
@section('title', __('Регистрация'))
@section('content')

	<h1 class="text-2xl font-semibold mb-4">{{ __('Скоро здесь появится страница регистрации') }}</h1>
	<p class="text-sm text-gray-600">
		{{ __('Мы работаем над этим. Загляните позже или вернитесь на главную.') }}
	</p>
	<a href="{{ route('home') }}" class="inline-block mt-6 text-blue-600 hover:underline">
		{{ __('На главную') }}
	</a>

@endsection
