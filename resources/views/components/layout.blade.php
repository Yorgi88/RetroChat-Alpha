<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#0a0e0a">

    <title>{{ $title ?? 'RETRO::CHAT' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=VT323&family=Share+Tech+Mono&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="retro-body">

    {{-- CRT Scanline Overlay --}}
    <div class="scanlines" aria-hidden="true"></div>

    {{-- Header --}}
    <x-header />

    {{-- Main Content --}}
    <main class="retro-main">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <x-footer />

</body>
</html>