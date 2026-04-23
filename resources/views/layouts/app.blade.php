<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="@yield('meta_keywords', 'accounting, audit, education, CAP, CIPA, courses, Tajikistan')">
    <meta name="description" content="@yield('meta_description', 'Public Institute of Professional Accountants and Auditors website and CMS.')">
    <title>@yield('title', $siteSettings['site_name'] ?? 'PIPAA CMS')</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>

<body class="min-h-screen bg-[radial-gradient(circle_at_top,_rgba(191,219,254,0.45),_transparent_40%),linear-gradient(180deg,_#f8fbff_0%,_#eef4f9_100%)] text-slate-900">
    <div class="relative flex min-h-screen flex-col overflow-x-hidden">
        <div class="absolute inset-x-0 top-0 -z-10 h-[30rem] bg-[linear-gradient(120deg,_rgba(15,23,42,0.96),_rgba(30,64,175,0.88)_55%,_rgba(8,47,73,0.85))]"></div>

        <x-auth />
        <x-header />
        <x-form.flash />
        <x-main />
        <x-footer />
    </div>

    @stack('scripts')
</body>
</html>
