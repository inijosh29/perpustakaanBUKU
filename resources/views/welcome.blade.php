<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perpustakaan</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-500 to-blue-700">

    <!-- NAVBAR -->
    <header class="w-full absolute top-0 right-0 p-6 flex justify-end z-50">
        @if (Route::has('login'))
            <nav class="flex items-center gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="px-5 py-2 border border-blue-700 text-blue-700 rounded-lg font-semibold
                        transition duration-300 ease-in-out transform
                        hover:bg-blue-50 hover:text-blue-800
                        active:bg-blue-100 active:text-blue-900">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="px-5 py-2 border border-blue-700 text-blue-700 rounded-lg font-semibold
                        transition duration-300 ease-in-out transform
                        hover:bg-blue-50 hover:text-blue-800
                        active:bg-blue-100 active:text-blue-900">
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="px-5 py-2 border border-blue-700 text-blue-700 rounded-lg font-semibold
                            transition duration-300 ease-in-out transform
                            hover:bg-blue-50 hover:text-blue-800
                            active:bg-blue-100 active:text-blue-900">
                            Register
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <!-- CONTENT -->
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-gray-50/80 backdrop-blur-md rounded-2xl shadow-2xl p-10 max-w-lg w-full text-center space-y-5">
            <h1 class="text-4xl font-extrabold text-blue-700">
                Perpustakaan App
            </h1>

            <p class="text-gray-700 leading-relaxed">
                Temukan dan kelola buku dengan mudah menggunakan
                <span class="font-semibold text-blue-600">Laravel</span> +
                <span class="font-semibold text-blue-600">Livewire</span>
            </p>
        </div>
    </div>

</body>

</html>
