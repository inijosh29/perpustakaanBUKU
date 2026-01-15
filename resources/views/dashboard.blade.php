<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 p-4">

        <!-- 3 Kotak Statistik -->
        <div class="grid gap-6 md:grid-cols-3">

            <!-- Total Koleksi Buku -->
            <div class="rounded-xl p-6 bg-blue-100 text-black shadow-lg flex flex-col justify-center items-center">
                <h3 class="text-sm font-medium">Total Koleksi Buku</h3>
                <span class="text-3xl font-bold mt-2">
                    {{ \App\Models\Book::count() }}
                </span>
            </div>

            <!-- Buku Sedang Dipinjam -->
            <div class="rounded-xl p-6 bg-orange-100 text-black shadow-lg flex flex-col justify-center items-center">
                <h3 class="text-sm font-medium">Buku Sedang Dipinjam</h3>
                <span class="text-3xl font-bold mt-2">
                    {{ \App\Models\Rental::where('status', 'rented')->count() }}
                </span>
            </div>

            <!-- Stock Tersedia -->
            <div class="rounded-xl p-6 bg-green-100 text-black shadow-lg flex flex-col justify-center items-center">
                <h3 class="text-sm font-medium">Stock Tersedia</h3>
                <span class="text-3xl font-bold mt-2">
                    {{ \App\Models\Book::sum('stock') }}
                </span>
            </div>

        </div>

        <!-- Aktivitas Rental (Realtime via Livewire) -->
        <div class="rounded-xl p-6 bg-white shadow-lg flex flex-col gap-4 overflow-auto">

            <h2 class="text-lg font-bold mb-4 text-black">
                Aktivitas Rental Terbaru
            </h2>

            <livewire:dashboard.recent-rentals />

        </div>

    </div>
</x-layouts.app>
