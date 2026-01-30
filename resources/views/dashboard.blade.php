<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-10 p-6 bg-gray-50">

        <!-- HEADER -->
<div
    class="relative overflow-hidden rounded-2xl px-8 pt-12 pb-36 text-gray-800 shadow-xl
           bg-cover bg-center bg-no-repeat"
    style="background-image: url('{{ asset('images/webtile2.jpg') }}');"
>
<div class="absolute inset-0 bg-black/40"></div>

            <div class="relative flex flex-col items-center justify-center gap-4 text-center">
                <h1 class="text-4xl tracking-tight text-white" style ="font family: 'WelcomeFont', sans-serif;">
                    Temukan dan jelajahi koleksi buku perpustakaan kami
                </h1>
                


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

    <!-- Total Buku -->
    <div
        class="group relative overflow-hidden rounded-3xl bg-white p-6 shadow-lg ring-1 ring-gray-100 transition-all hover:-translate-y-1 hover:shadow-xl">

        <!-- Accent -->
        <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-emerald-400 to-teal-400"></div>

        <p class="text-sm font-medium text-gray-500">
            Total Koleksi Buku
        </p>

        <div class="mt-3 flex items-end justify-between">
            <p class="text-4xl font-bold text-gray-900">
                {{ \App\Models\Book::count() }}
            </p>

            <div
                class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600">
                📚
            </div>
        </div>
    </div>

    <!-- Dipinjam -->
    <div
        class="group relative overflow-hidden rounded-3xl bg-white p-6 shadow-lg ring-1 ring-gray-100 transition-all hover:-translate-y-1 hover:shadow-xl">

        <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-indigo-400 to-purple-400"></div>

        <p class="text-sm font-medium text-gray-500">
            Buku Sedang Dipinjam
        </p>

        <div class="mt-3 flex items-end justify-between">
            <p class="text-4xl font-bold text-gray-900">
                {{ \App\Models\Rental::where('status', 'rented')->count() }}
            </p>

            <div
                class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-100 text-indigo-600">
                🔄
            </div>
        </div>
    </div>

    <!-- Stock -->
    <div
        class="group relative overflow-hidden rounded-3xl bg-white p-6 shadow-lg ring-1 ring-gray-100 transition-all hover:-translate-y-1 hover:shadow-xl">

        <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-amber-400 to-orange-400"></div>

        <p class="text-sm font-medium text-gray-500">
            Stock Tersedia
        </p>

        <div class="mt-3 flex items-end justify-between">
            <p class="text-4xl font-bold text-gray-900">
                {{ \App\Models\Book::sum('stock') }}
            </p>

            <div
                class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100 text-amber-600">
                📦
            </div>
        </div>
    </div>

</div>


        <!-- AKTIVITAS -->
        <div class="rounded-2xl bg-white text-slate-800 p-8 shadow-md ring-1 ring-gray-200">
    <h2 class="mb-8 text-center text-2xl tracking-tight text-black"  style ="font family: 'WelcomeFont', sans-serif;">
        Aktivitas Rental Terbaru
    </h2>

    <livewire:dashboard.recent-rentals />
</div>


        <!-- FOOTER -->
        <footer class="rounded-xl py-4 text-center text-sm text-gray-500 ">
            © {{ date('Y') }} All rights reserved.
        </footer>

    </div>
</x-layouts.app>
