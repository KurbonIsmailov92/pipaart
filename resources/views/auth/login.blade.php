@extends('layouts.app')
@section('title', __('Вход'))

@section('content')
    <div class="flex items-center justify-center min-h-screen">
        <div class="px-8 py-6 mt-4 text-left shadow-lg rounded-lg max-w-md w-full">
            <h3 class="text-2xl font-bold text-center">{{ __('Вход в аккаунт') }}</h3>
            <x-form.form method="POST" action="{{ route('auth.login') }}">
                <div class="mt-4 space-y-4">
                    <div>
                        <x-form.input name="email" type="email" label="Email" placeholder="Email" />
                        <x-form.error>@error('email'){{ $message }}@enderror</x-form.error>
                    </div>
                    <div>
                        <x-form.input name="password" type="password" label="Пароль" placeholder="Пароль" />
                        <x-form.error>@error('password'){{ $message }}@enderror</x-form.error>
                    </div>
                    <div class="flex items-baseline justify-between">
                        <x-form.button>{{ __('Войти') }}</x-form.button>
                        <a href="{{ route('auth.register') }}" class="text-sm text-blue-600 hover:underline">{{ __('Зарегистрироваться') }}</a>
                    </div>
                </div>
            </x-form.form>
        </div>
    </div>
@endsection
