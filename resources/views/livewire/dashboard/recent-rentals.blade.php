<div class="space-y-6">
    {{-- LIST RENTAL --}}
    <div wire:poll.3000ms class="grid gap-6">
        @forelse($rentals as $rental)
            <div class="flex justify-between items-center p-6 bg-white dark:bg-gray-800 rounded-xl border border-gray-300 dark:border-gray-600 transition hover:shadow-xl">

                <div class="space-y-1">
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">
                        {{ $rental->user->name }}
                    </p>

                    <p class="text-gray-600 dark:text-gray-300 font-medium">
                        {{ $rental->book->title }}
                    </p>

                    <p class="text-sm mt-2">
                        @if($rental->status === 'rented')
                            <span class="inline-flex items-center gap-1 bg-blue-100 text-blue-800 px-2 py-1 rounded-full font-semibold text-xs">
                                📕 Sedang dipinjam
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 bg-green-100 text-green-800 px-2 py-1 rounded-full font-semibold text-xs">
                                📗 Sudah dikembalikan
                            </span>
                        @endif
                    </p>
                </div>

                <div class="text-right text-sm text-gray-500 dark:text-gray-400 space-y-1">
                    <p class="font-medium">
                        Pinjam:
                        <span class="font-normal">
                            {{ \Carbon\Carbon::parse($rental->rented_at)->format('d M Y') }}
                        </span>
                    </p>

                    @if($rental->returned_at)
                        <p class="font-medium">
                            Kembali:
                            <span class="font-normal">
                                {{ \Carbon\Carbon::parse($rental->returned_at)->format('d M Y') }}
                            </span>
                        </p>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-center text-gray-400 dark:text-gray-500">
                Belum ada aktivitas.
            </p>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    @if ($rentals->hasPages())
        <div class="flex justify-center">
            {{ $rentals->links() }}
        </div>
    @endif
</div>
