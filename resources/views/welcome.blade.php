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

<body class="min-h-screen bg-white font-sans">

    <!-- SPLIT SECTION -->
    <div class="flex min-h-screen flex-col md:flex-row">

        <!-- LEFT: TEXT -->
        <div class="flex w-full md:w-1/2 items-center justify-center px-10">
            <div class="max-w-md space-y-6">
                <h1 class="text-4xl font-extrabold tracking-tight text-emerald-700">
                    Perpustakaan App
                </h1>

                <p class="leading-relaxed text-gray-600">
                    Kelola dan jelajahi koleksi buku dengan mudah 
                    dalam satu platform perpustakaan digital.
                    <span class="font-semibold text-emerald-600"></span> 
                    <span class="font-semibold text-emerald-600"></span>
                </p>

                <div class="flex gap-4 pt-4">
                    <a href="{{ route('login') }}"
                       class="rounded-xl bg-emerald-600 px-6 py-3
                              font-semibold text-white shadow-lg
                              transition-all duration-300
                              hover:-translate-y-0.5 hover:bg-emerald-700">
                        Mulai Sekarang
                    </a>

                    <a href="{{ route('register') }}"
                       class="rounded-xl border border-emerald-600 px-6 py-3
                              font-semibold text-emerald-700
                              transition-all duration-300
                              hover:bg-emerald-50">
                        Daftar
                    </a>
                </div>
            </div>
        </div>

       <!-- MAIN IMAGE -->
<div
    class="relative hidden md:block md:w-1/2"
    style="background-image: url('{{ asset('images/pexels-pixabay-159711.jpg') }}');
           background-size: cover;
           background-position: center;">

    <!-- OVERLAY IMAGE -->
    <div
        class="absolute inset-0 opacity-30"
        style="background-image: url('{{ asset('images/pexels-pixabay-159711.jpg') }}');
               background-size: cover;
               background-position: center;">
    </div>
</div>

    </div>

</body>
</html>
