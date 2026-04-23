<div class="shell-container pt-4">
    <div class="flex flex-col gap-2 text-sm text-white/85 sm:flex-row sm:items-center sm:justify-end">
        @auth
            <div class="flex flex-wrap items-center justify-end gap-3">
                <span class="rounded-full border border-white/20 bg-white/10 px-3 py-1 backdrop-blur">{{ auth()->user()->name }}</span>
                @if(auth()->user()->hasRole(['admin', 'teacher']))
                    <a href="{{ route('admin.dashboard') }}" class="pill-link">Admin panel</a>
                @endif
                <form action="{{ route('auth.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="pill-link">Logout</button>
                </form>
            </div>
        @else
            <div class="flex flex-wrap items-center justify-end gap-3">
                <a href="{{ route('auth.register') }}" class="pill-link">Register</a>
                <a href="{{ route('auth.login') }}" class="pill-link">Login</a>
            </div>
        @endauth
    </div>
</div>
