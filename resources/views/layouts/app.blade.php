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
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700;800&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>

<body class="min-h-screen overflow-x-hidden text-slate-900">
    <div class="site-grid flex min-h-screen w-full flex-col overflow-x-hidden">
        <div class="pointer-events-none absolute inset-x-0 top-0 -z-10 h-[38rem] overflow-hidden">
            <div class="absolute inset-0 bg-[linear-gradient(160deg,rgba(20,57,80,0.96)_0%,rgba(45,112,151,0.78)_48%,rgba(215,187,119,0.38)_100%)]"></div>
            <div class="ui-pattern absolute inset-0 opacity-30"></div>
            <div class="absolute inset-0 bg-cover bg-center opacity-20" style="background-image:url('{{ \Illuminate\Support\Facades\Vite::asset('resources/images/bg.jpg') }}')"></div>
            <div class="absolute inset-x-0 bottom-0 h-40 bg-gradient-to-b from-transparent to-[#f3f6f6]"></div>
        </div>

        <x-auth />
        <x-header />
        <x-form.flash />
        <x-main />
        <x-footer />
    </div>

    @stack('scripts')
</body>
</html>
