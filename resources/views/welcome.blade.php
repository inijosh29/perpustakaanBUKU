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

<body class="min-h-screen bg-gradient-to-br from-blue-500 to-blue-700">

    <!-- NAVBAR -->
    <header class="w-full absolute top-0 right-0 p-6 flex justify-end z-50">
        @if (Route::has('login'))
            <nav class="flex items-center gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="px-5 py-2 bg-white text-blue-700 rounded-lg shadow-md hover:bg-blue-50 transition font-semibold">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="px-4 py-2 text-white font-medium hover:underline">
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="px-5 py-2 bg-white text-blue-700 rounded-lg shadow-md hover:bg-blue-50 transition font-semibold">
                            Register
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <!-- CONTENT -->
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-2xl shadow-2xl p-10 max-w-lg w-full text-center space-y-5">
            <h1 class="text-4xl font-extrabold text-blue-700">
                Catatan App
            </h1>

            <p class="text-gray-600 leading-relaxed">
                Simpan dan kelola catatanmu dengan mudah menggunakan
                <span class="font-semibold text-blue-600">Laravel</span> +
                <span class="font-semibold text-blue-600">Livewire</span>
            </p>

            <div class="flex justify-center gap-4 pt-4">
                <a href="{{ route('login') }}"
                   class="px-6 py-3 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition">
                    Mulai Sekarang
                </a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                       class="px-6 py-3 border border-blue-600 text-blue-600 rounded-xl font-semibold hover:bg-blue-50 transition">
                        Daftar
                    </a>
                @endif
            </div>
        </div>
    </div>

</body>
</html>
