<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Catatan</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-blue-600 min-h-screen">

    <!-- NAVBAR -->
    <header class="w-full absolute top-0 right-0 p-6 flex justify-end z-50">
        @if (Route::has('login'))
            <nav class="flex items-center gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="px-5 py-2 bg-white text-black rounded-md shadow hover:bg-gray-100 transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="px-5 py-2 text-black hover:underline">
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="px-5 py-2 bg-white text-black rounded-md shadow hover:bg-gray-100 transition">
                            Register
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <!-- CONTENT -->
    <div class="flex items-center justify-center min-h-screen">
        <div class="text-center space-y-4">
            <h1 class="text-4xl font-bold text-white">Catatan App</h1>
            <p class="text-white/80">
                Simpan dan kelola catatanmu dengan mudah menggunakan Laravel + Livewire
            </p>
        </div>
    </div>

</body>
</html>
