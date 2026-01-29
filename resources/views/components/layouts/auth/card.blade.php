<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-neutral-100 antialiased">

<div class="flex min-h-screen flex-col items-center justify-center gap-6 p-6 md:p-10">
    <div class="flex w-full max-w-md flex-col gap-6">

        <!-- LOGO -->
        <a href="{{ route('home') }}"
           class="flex flex-col items-center gap-2 font-medium text-emerald-700">

            <span class="flex h-9 w-9 items-center justify-center rounded-md">
                <x-app-logo-icon class="size-9 fill-current text-emerald-600" />
            </span>

            <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
        </a>

        <!-- CARD -->
        <div class="rounded-xl border-2 border-emerald-500 bg-white text-emerald-700 shadow-lg">
            <div class="px-10 py-8">
                {{ $slot }}
            </div>
        </div>

    </div>
</div>

@fluxScripts
</body>
</html>
