<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-10 p-6 bg-gray-50">

        <!-- HEADER -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-400 via-emerald-200 to-white px-8 pt-10 pb-32 text-gray-800 shadow-xl">
            <!-- decorative blur -->
            <div class="absolute -top-20 -right-20 h-72 w-72 rounded-full bg-white/10 blur-3xl"></div>

            <div class="relative flex flex-col items-center justify-center gap-4 text-center">
    <h1 class="text-3xl font-bold tracking-tight text-emerald-800">
        Selamat Datang </h1>

    <a href="{{ route('books.index') }}"
       class="inline-flex items-center gap-3 rounded-2xl bg-white/80 px-5 py-3 text-base font-semibold text-emerald-700
              shadow-md backdrop-blur transition-all
              hover:-translate-y-0.5 hover:bg-white hover:shadow-xl">
        <span>Lihat daftar buku</span>
    </a>
</div>


        </div>

        <!-- STAT CARD -->
        <div class="relative -mt-24 grid gap-6 md:grid-cols-3 z-10">

            <div class="group rounded-2xl bg-white p-6 shadow-md ring-1 ring-gray-200 transition-all hover:-translate-y-1 hover:shadow-xl">
                <p class="text-sm text-gray-500">
                    Total Koleksi Buku
                </p>
                <p class="mt-2 text-4xl font-bold text-gray-900">
                    {{ \App\Models\Book::count() }}
                </p>
            </div>

            <div class="group rounded-2xl bg-white p-6 shadow-md ring-1 ring-gray-200 transition-all hover:-translate-y-1 hover:shadow-xl">
                <p class="text-sm text-gray-500">
                    Buku Sedang Dipinjam
                </p>
                <p class="mt-2 text-4xl font-bold text-gray-900">
                    {{ \App\Models\Rental::where('status', 'rented')->count() }}
                </p>
            </div>

            <div class="group rounded-2xl bg-white p-6 shadow-md ring-1 ring-gray-200 transition-all hover:-translate-y-1 hover:shadow-xl">
                <p class="text-sm text-gray-500">
                    Stock Tersedia
                </p>
                <p class="mt-2 text-4xl font-bold text-gray-900">
                    {{ \App\Models\Book::sum('stock') }}
                </p>
            </div>

        </div>

        <!-- AKTIVITAS -->
        <div class="rounded-2xl bg-white p-8 shadow-md ring-1 ring-gray-200">
    <h2 class="mb-8 text-center text-2xl font-bold tracking-tight text-gray-800">
        Aktivitas Rental Terbaru
    </h2>

    <livewire:dashboard.recent-rentals />
</div>


        <!-- FOOTER -->
        <footer class="rounded-xl bg-white py-4 text-center text-sm text-gray-500 shadow-inner ring-1 ring-gray-200">
            © {{ date('Y') }} All rights reserved.
        </footer>

    </div>
</x-layouts.app>
