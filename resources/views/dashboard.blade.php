<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 p-4">

        <!-- 3 Kotak Statistik -->
        <div class="grid gap-6 md:grid-cols-3">
            <!-- Total Koleksi Buku -->
            <div class="rounded-xl p-6 bg-blue-200 text-black shadow-lg hover:shadow-2xl transition-transform transform hover:-translate-y-1 border border-transparent ring-1 ring-blue-300 font-sans">
                <h3 class="text-sm font-semibold tracking-wide">Total Koleksi Buku</h3>
                <span class="text-3xl font-extrabold mt-2 tracking-tight">
                    {{ \App\Models\Book::count() }}
                </span>
            </div>

            <!-- Buku Sedang Dipinjam -->
            <div class="rounded-xl p-6 bg-orange-200 text-black shadow-lg hover:shadow-2xl transition-transform transform hover:-translate-y-1 border border-transparent ring-1 ring-orange-300 font-sans">
                <h3 class="text-sm font-semibold tracking-wide">Buku Sedang Dipinjam</h3>
                <span class="text-3xl font-extrabold mt-2 tracking-tight">
                    {{ \App\Models\Rental::where('status', 'rented')->count() }}
                </span>
            </div>

            <!-- Stock Tersedia -->
            <div class="rounded-xl p-6 bg-green-200 text-black shadow-lg hover:shadow-2xl transition-transform transform hover:-translate-y-1 border border-transparent ring-1 ring-green-300 font-sans">
                <h3 class="text-sm font-semibold tracking-wide">Stock Tersedia</h3>
                <span class="text-3xl font-extrabold mt-2 tracking-tight">
                    {{ \App\Models\Book::sum('stock') }}
                </span>
            </div>
        </div>

        <!-- Aktivitas Rental (Realtime via Livewire) -->
        <div class="rounded-xl p-6 bg-white shadow-md flex flex-col gap-4 overflow-auto border border-gray-200">
            <h2 class="text-lg font-bold mb-4 text-black ">
                Aktivitas Rental Terbaru
            </h2>
            <livewire:dashboard.recent-rentals />
        </div>

        <!-- Footer -->
        <footer class="mt-6 p-4 bg-gray-100 text-gray-700 rounded-xl shadow-inner border border-gray-200 text-center">
            <p>© {{ date('Y') }}  All rights reserved.</p>
            <p></p>
        </footer>

        <p>paman</p>
        <p>wanita</p>
        <p>iwan</p>

    </div>
</x-layouts.app>
