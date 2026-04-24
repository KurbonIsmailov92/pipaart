<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700;800&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
@php($publicLocale = session('locale', config('app.locale', 'ru')))
<body class="bg-[linear-gradient(180deg,#edf3f4_0%,#f7f4ec_100%)] text-slate-900">
<div class="min-h-screen lg:grid lg:grid-cols-[290px_1fr]">
    <aside class="bg-[#143950] px-5 py-6 text-slate-100 lg:sticky lg:top-0 lg:h-screen lg:overflow-y-auto">
        <div class="flex items-start justify-between gap-4">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="text-2xl font-semibold tracking-wide">PIPAA CMS</a>
                <p class="mt-2 text-sm text-white/60">Admin panel for pages, courses, schedules, news, gallery, settings, and users.</p>
            </div>
            <a href="{{ route('home', ['locale' => $publicLocale]) }}" class="pill-link lg:hidden">Site</a>
        </div>

        <nav class="mt-8 flex gap-2 overflow-x-auto pb-2 lg:block lg:space-y-2 lg:overflow-visible">
            <a href="{{ route('admin.dashboard') }}" class="admin-nav-link whitespace-nowrap">Dashboard</a>
            @if(auth()->user()?->isAdmin())
                <a href="{{ route('admin.pages.index') }}" class="admin-nav-link whitespace-nowrap">Pages</a>
            @endif
            <a href="{{ route('admin.courses.index') }}" class="admin-nav-link whitespace-nowrap">Courses</a>
            <a href="{{ route('admin.schedules.index') }}" class="admin-nav-link whitespace-nowrap">Schedule</a>
            <a href="{{ route('admin.news.index') }}" class="admin-nav-link whitespace-nowrap">News</a>
            @if(auth()->user()?->isAdmin())
                <a href="{{ route('admin.gallery.index') }}" class="admin-nav-link whitespace-nowrap">Gallery</a>
                <a href="{{ route('admin.users.index') }}" class="admin-nav-link whitespace-nowrap">Users</a>
                <a href="{{ route('admin.settings.index') }}" class="admin-nav-link whitespace-nowrap">Settings</a>
            @endif
        </nav>

        <div class="mt-8 rounded-3xl border border-white/10 bg-white/10 p-4 text-sm backdrop-blur">
            <p class="font-medium">{{ auth()->user()?->name }}</p>
            <p class="mt-1 text-white/60">{{ auth()->user()?->role?->label() ?? auth()->user()?->role?->value }}</p>
            <div class="mt-4 flex flex-wrap gap-3">
                <a href="{{ route('home', ['locale' => $publicLocale]) }}" class="pill-link">View Site</a>
                <form action="{{ route('auth.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="pill-link border-red-200/40 bg-red-500/10 text-red-100 hover:bg-red-500/20">Logout</button>
                </form>
            </div>
        </div>
    </aside>

    <main class="px-4 py-6 sm:px-6 lg:px-10">
        <header class="mb-8 flex flex-col gap-3 border-b border-slate-200 pb-5 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm uppercase tracking-[0.3em] text-slate-500">Admin</p>
                <h1 class="text-3xl font-semibold">@yield('page-title', 'Dashboard')</h1>
            </div>
            <div class="text-sm text-slate-500">
                Queue: <span class="font-medium text-slate-700">{{ config('queue.default') }}</span>
            </div>
        </header>

        @if(session('success'))
            <x-ui.alert variant="success" class="mb-6">{{ session('success') }}</x-ui.alert>
        @endif

        @yield('content')
    </main>
</div>
</body>
</html>
