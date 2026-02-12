<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Peminjam Buku</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-white font-sans flex flex-col">

    <!-- SPLIT SECTION -->
    <div class="flex flex-1 flex-col md:flex-row">

        <!-- LEFT: TEXT -->
        <div class="flex w-full md:w-1/2 items-center justify-center px-10">
            <div class="max-w-md space-y-6">
                <h1 class="text-4xl font-extrabold tracking-tight text-emerald-700">
                    Peminjaman Buku Mudah & Cepat
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

       <!-- MAIN IMAGE (KEMBALI KE FOTO ASLI ANDA) -->
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

    <!-- FOOTER SECTION (Lebih Kecil & Kompak) -->
    <footer class="w-full bg-emerald-950 text-emerald-50 border-t border-emerald-900 mt-auto">
        <!-- Updated: max-w-7xl -> max-w-4xl (Lebar diperkecil) -->
        <!-- Updated: py-12 -> py-8 (Tinggi vertikal diperkecil) -->
        <div class="max-w-4xl mx-auto px-6 py-8">
            <!-- Updated: gap-10 -> gap-6 (Jarak antar kolom dirapatkan) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Kolom 1: Produk & Copyright -->
                <div class="space-y-3">
                    <h2 class="text-xl font-bold text-white tracking-wide">
                        Peminjaman Buku
                    </h2>
                    <p class="text-sm text-emerald-200/80 leading-relaxed">
                       web sederhana Pinjam Buku
                    </p>
                    <p class="text-xs text-emerald-300/60 pt-1">
                        &copy; {{ date('Y') }} Perpustakaan. All rights reserved.
                    </p>
                </div>

                <!-- Kolom 2: Kontak (Alamat, Email, WA) -->
                <div class="space-y-3">
                    <h3 class="text-sm font-semibold text-white border-b border-emerald-800 pb-1 inline-block">
                        Hubungi Kami
                    </h3>
                    <ul class="space-y-3 text-sm text-emerald-100">
                        <!-- Email -->
                        <li class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <a href="parabangbagus@gmail.com" class="hover:text-white transition-colors">parabangbagus@gmail.com</a>
                        </li>

                        <!-- Nomor WA -->
                        <li class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <a href="https://wa.me/6285779235820" target="_blank" class="hover:text-white transition-colors">+62 857 7923 5820</a>
                        </li>
                    </ul>
                </div>

                <!-- Kolom 3: GitHub & Sosial -->
                <div class="space-y-3">
                    <h3 class="text-sm font-semibold text-white border-b border-emerald-800 pb-1 inline-block">
                        ohio, temu, backrooms, area 51
                    </h3>
                    <p class="text-xs text-emerald-200/80 mb-2">
                        Dukung pengembangan aplikasi ini dengan mengunjungi repository resmi kami.
                    </p>

                    <a href="https://github.com/inijosh29/perpustakaanBUKU.git" target="_blank" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-900 hover:bg-emerald-800 text-white rounded-lg transition-all duration-300 group">
                        <!-- GitHub Icon -->
                        <svg class="w-5 h-5 text-white group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-xs font-medium">GitHub Repository</span>
                    </a>
                </div>

            </div>
        </div>
    </footer>

</body>
</html>