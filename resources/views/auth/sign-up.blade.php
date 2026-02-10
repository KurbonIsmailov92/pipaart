@extends('layouts.auth')
@section('title', 'Регистрация')
@section('content')

    <x-form.auth-forms title="Регистрация" action="{{ route('auth.sign-up.store') }}" method="POST">
        @csrf

        <x-form.auth-input type="text"
                            placeholder="Имя"
                            required
                            :isError="$errors->has('name')"
                            name="name"
                            value="{{old('name')}}"
        />

        <x-form.auth-input type="email"
                            placeholder="E-mail"
                            required
                            :isError="$errors->has('email')"
                            name="email"
        />

        @error('email')
        <x-form.error> {{$message}} </x-form.error>
        @enderror

        <x-form.auth-input type="password"
                            placeholder="Пароль"
                            required
                            name="password"
                            :isError="$errors->has('password')"
        />

        @error('password')
        <x-form.error> {{$message}} </x-form.error>
        @enderror

        <x-form.auth-input type="password"
                            placeholder="Повторите пароль"
                            required
                            name="password_confirmation"
                            :isError="$errors->has('password_confirmation')"
        />

        @error('password_confirmation')
        <x-form.error> {{$message}} </x-form.error>
        @enderror

        <x-form.button>Зарегистрироваться</x-form.button>


        <x-form.button>
            <div class="space-y-3 mt-5">
                <div class="text-xxs md:text-xs">
                    <a href="{{route('auth.login')}}" class="text-white hover:text-white/70 font-bold">Войти в аккаунт</a>
                </div>
            </div>
        </x-form.button>

    </x-form.auth-forms>

@endsection
