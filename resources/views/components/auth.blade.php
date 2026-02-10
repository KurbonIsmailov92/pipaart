<div class="container mx-auto text-blue-950 font-medium text-lg-end sm:text-left sm:ml-4 pr-8 pt-2 text-center">
    @auth
        <span class="pr-2">{{ auth()->user()->name }}</span>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           class="hover:text-blue-700 hover:underline transform duration-300 block sm:inline">
            {{ __('Выйти') }}
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    @else
        <a class="hover:text-blue-700 hover:underline transform duration-300 block sm:inline pr-2"
           href="{{ route('auth.register') }}">{{ __('Регистрация') }}</a>
        <a class="hover:text-blue-700 hover:underline transform duration-300 block sm:inline"
           href="{{ route('auth.login') }}">{{ __('Вход') }}</a>
    @endauth
</div>


