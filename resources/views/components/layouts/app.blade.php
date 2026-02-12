<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'App' }}</title>

    {{-- Head assets --}}
    @include('partials.head')

    {{-- Livewire --}}
    @livewireStyles

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #000000;
        }

        /* Flux navlist styling (optional) */
        flux\:navlist .nav-item,
        flux\:navlist .nav-link {
            border: none !important;
            text-decoration: none !important;
        }

        flux\:navlist .nav-item.current .nav-link {
            background-color: #4ade80 !important;
            color: #000 !important;
        }
    </style>
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">

    {{-- ================= TOP NAVBAR ================= --}}
    @include('components.layouts.app.header')

    {{-- ================= PAGE CONTENT ================= --}}
    <main class="min-h-[calc(100vh-64px)] bg-gray-100 p-6">
        {{ $slot }}
    </main>

    {{-- Livewire & Flux --}}
    @livewireScripts
    @fluxScripts

</body>
</html>
