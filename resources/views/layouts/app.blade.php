<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ config('seguce92.data.description') }}" />
    <meta name="keywords" content="Ulaav, lms, Educacion en Línea" />
    <meta name="author" content="Ulaav" />

    @include('component.favicon')

    @yield('seo')

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/@fortawesome/fontawesome-free/css/all.min.css') }}"/>
    <link href="https://fonts.googleapis.com/css?family=Nunito&display=swap" rel="stylesheet">
    @stack('style')
</head>
<body class="leading-relaxed tracking-wide flex flex-col antialiased bg-gray-200">
    <div id="app">
        @yield('content')
    </div>
    <script src="{{ mix('js/manifest.js') }}" defer></script>
    <script src="{{ mix('js/vendor.js') }}" defer></script>
    @stack('script')
</body>
</html>
  