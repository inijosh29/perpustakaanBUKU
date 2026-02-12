<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-8 p-6 bg-gray-50/50">

        <div class="relative overflow-hidden rounded-3xl shadow-2xl shadow-emerald-900/10">
            <div class="absolute inset-0 bg-cover bg-center bg-no-repeat transition-transform duration-700 hover:scale-105"
                 style="background-image: url('{{ asset('images/webtile2.jpg') }}');">
            </div>
            <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/40 to-transparent"></div>

            <div class="relative flex flex-col items-center justify-center gap-6 px-8 pt-16 pb-32 text-center">
                <h1 class="max-w-3xl text-4xl font-bold tracking-tight text-white md:text-5xl" 
                    style="font-family: 'WelcomeFont', sans-serif; line-height: 1.2;">
                    Temukan dan jelajahi koleksi buku kami
                </h1>
                
                <a href="{{ route('books.index') }}"
                   class="group inline-flex items-center gap-2 rounded-full bg-white px-6 py-3 text-sm font-semibold text-emerald-700 shadow-lg transition-all hover:bg-emerald-50 hover:px-8">
                    <span>Lihat daftar buku</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        </div>

        <div class="relative -mt-20 px-4">
            <div class="grid gap-6 md:grid-cols-3">
                <div class="group relative overflow-hidden rounded-2xl bg-white p-6 shadow-xl shadow-gray-200/50 transition-all hover:-translate-y-2">
                    <div class="absolute inset-x-0 top-0 h-1.5 bg-gradient-to-r from-emerald-400 to-teal-500"></div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-gray-400">Total Koleksi</p>
                            <p class="mt-1 text-3xl font-black text-gray-800">{{ \App\Models\Book::count() }}</p>
                        </div>
                        {{-- <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-2xl shadow-inner transition-transform group-hover:rotate-12">
                            
                        </div> --}}
                    </div>
                    <p class="mt-4 text-xs text-gray-500 font-medium">Data buku terdaftar</p>
                </div>

                <div class="group relative overflow-hidden rounded-2xl bg-white p-6 shadow-xl shadow-gray-200/50 transition-all hover:-translate-y-2">
                    <div class="absolute inset-x-0 top-0 h-1.5 bg-gradient-to-r from-indigo-400 to-purple-500"></div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-gray-400">Sedang Dipinjam</p>
                            <p class="mt-1 text-3xl font-black text-gray-800">{{ \App\Models\Rental::where('status', 'rented')->count() }}</p>
                        </div>
                        {{-- <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-50 text-2xl shadow-inner transition-transform group-hover:rotate-12">
                            
                        </div> --}}
                    </div>
                    <p class="mt-4 text-xs text-gray-500 font-medium">Sirkulasi aktif hari ini</p>
                </div>

                <div class="group relative overflow-hidden rounded-2xl bg-white p-6 shadow-xl shadow-gray-200/50 transition-all hover:-translate-y-2">
                    <div class="absolute inset-x-0 top-0 h-1.5 bg-gradient-to-r from-orange-400 to-amber-500"></div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-gray-400">Stok Tersedia</p>
                            <p class="mt-1 text-3xl font-black text-gray-800">{{ \App\Models\Book::sum('stock') }}</p>
                        </div>
                        {{-- <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-orange-50 text-2xl shadow-inner transition-transform group-hover:rotate-12">
                            
                        </div> --}}
                    </div>
                    <p class="mt-4 text-xs text-gray-500 font-medium">Item siap dipinjam</p>
                </div>
            </div>
        </div>

        <div class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-gray-200">
            <div class="border-b border-gray-50 px-8 py-6">
                <h2 class="text-xl font-bold text-gray-800" style="font-family: 'WelcomeFont', sans-serif;">
                    Aktivitas Pinjam Terbaru
                </h2>
                <p class="text-sm text-gray-500">Pantau pergerakan buku masuk dan keluar secara real-time</p>
            </div>
            <div class="p-8">
                <livewire:dashboard.recent-rentals />
            </div>
        </div>

        <footer class="mt-auto py-6 text-center">
            <p class="text-sm font-medium text-gray-400">
                &copy; {{ date('Y') }} <span class="text-emerald-600">Perpustakaan Digital</span>. All rights reserved.
            </p>
        </footer>

    </div>
</x-layouts.app>