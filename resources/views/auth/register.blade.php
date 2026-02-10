@extends('layouts.app')
@section('title', __('Регистрация'))

@section('content')
    <div class="flex items-center justify-center min-h-screen">
        <div class="px-8 py-6 mt-4 text-left shadow-lg rounded-lg max-w-md w-full">
            <h3 class="text-2xl font-bold text-center">{{ __('Создать аккаунт') }}</h3>
            <x-form.form method="POST" action="{{ route('auth.register') }}">
                <div class="mt-4 space-y-4">
                    <div>
                        <x-form.input name="name" type="text" label="Имя" placeholder="Имя" />
                        <x-form.error>@error('name'){{ $message }}@enderror</x-form.error>
                    </div>
                    <div>
                        <x-form.input name="email" type="email" label="Email" placeholder="Email" />
                        <x-form.error>@error('email'){{ $message }}@enderror</x-form.error>
                    </div>
                    <div>
                        <x-form.input name="password" type="password" label="Пароль" placeholder="Пароль" />
                        <x-form.error>@error('password'){{ $message }}@enderror</x-form.error>
                    </div>
                    <div>
                        <x-form.input name="password_confirmation" type="password" label="Подтвердите пароль" placeholder="Подтвердите пароль" />
                    </div>
                    <div class="flex items-baseline justify-between">
                        <x-form.button>{{ __('Зарегистрироваться') }}</x-form.button>
                        <a href="{{ route('auth.login') }}" class="text-sm text-blue-600 hover:underline">{{ __('Уже есть аккаунт?') }}</a>
                    </div>
                </div>
            </x-form.form>
        </div>
    </div>
@endsection
