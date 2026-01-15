<div wire:poll.3000ms class="grid gap-4">
    @forelse($rentals as $rental)
        <div class="flex justify-between items-center p-4 border border-black rounded-lg bg-white shadow">
            <div>
                <p class="font-semibold text-black">
                    {{ $rental->user->name }}
                </p>

                <p class="text-gray-700">
                    {{ $rental->book->title }}
                </p>

                <p class="text-sm mt-1">
                    @if($rental->status === 'rented')
                        <span class="text-blue-600 font-semibold">
                            📕 Sedang dipinjam
                        </span>
                    @else
                        <span class="text-green-600 font-semibold">
                            📗 Sudah dikembalikan
                        </span>
                    @endif
                </p>
            </div>

            <div class="text-right text-sm text-gray-600">
                <p>Pinjam: {{ \Carbon\Carbon::parse($rental->rented_at)->format('d M Y') }}</p>

                @if($rental->returned_at)
                    <p>Kembali: {{ \Carbon\Carbon::parse($rental->returned_at)->format('d M Y') }}</p>
                @endif
            </div>
        </div>
    @empty
        <p class="text-gray-500">Belum ada aktivitas.</p>
    @endforelse
</div>
