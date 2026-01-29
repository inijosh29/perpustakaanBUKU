<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white antialiased">

    <div class="flex min-h-screen items-center justify-center p-6">
        <div class="flex w-full max-w-sm flex-col gap-6">

            <!-- LOGO -->
            <a href="{{ route('home') }}"
               class="flex flex-col items-center gap-2 font-medium">

                <span class="flex h-9 w-9 mb-1 items-center justify-center rounded-md">
                    <x-app-logo-icon class="size-9 text-black" />
                </span>

                <span class="sr-only">{{ config('app.name') }}</span>
            </a>

            <!-- CONTENT -->
            <div>
                {{ $slot }}
            </div>

        </div>
    </div>

    @fluxScripts
</body>
</html>
