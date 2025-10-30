<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords"
          content="@yield('meta_keywords', 'институт, бухгалтер, аудиторы, Таджикистан, курсы, сертификаты, обучение, CAP, CIPA, ACCA')"/>
    <meta name="description"
          content="@yield('meta_description', 'Общественный Институт профессиональных бухгалтеров и аудиторов Республики Таджикистан')"/>
    <title>@yield('title', 'PIPAArt')</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:ital,wght@400;500;600&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>

<body class="font-hanken-grotesk flex flex-col min-h-screen"
      style="background-image: url('{{ \Illuminate\Support\Facades\Vite::asset("resources/images/bg.jpg") }}');
      background-size: cover;
      background-position: center;">

<x-auth/>

<x-header/>

<x-form.flash/>

<x-main/>

<x-footer/>

@stack('scripts')
</body>
</html>
