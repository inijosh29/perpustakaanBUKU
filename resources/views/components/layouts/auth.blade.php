<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-neutral-100 antialiased">

    <div class="flex min-h-screen items-center justify-center p-6">
        <div class="w-full max-w-md">
            {{ $slot }}
        </div>
    </div>

    @fluxScripts
</body>
</html>
