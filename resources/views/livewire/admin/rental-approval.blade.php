<div class="p-4 bg-white">
    {{-- <h1 class="text-2xl font-bold mb-4 text-zinc-900">
        Form 
    </h1> --}}

    {{-- ALERT SUCCESS --}}
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ALERT ERROR --}}
    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($rentals->isEmpty())
        <p class="text-gray-600">Tidak ada permintaan pinjam buku.</p>
    @else
        <div class="overflow-x-auto shadow-sm rounded">
            <table class="w-full table-auto border border-gray-300">
                <thead>
                    <tr class="bg-gray-100 text-zinc-900">
                        <th class="border px-4 py-2">ID</th>
                        <th class="border px-4 py-2">User</th>
                        <th class="border px-4 py-2">Buku</th>
                        <th class="border px-4 py-2">Stock Buku</th>
                        <th class="border px-4 py-2">Tanggal Pinjam</th>
                        <th class="border px-4 py-2 text-center">Action</th>
                    </tr>
                </thead>

                <tbody class="bg-white text-zinc-900">
                    @foreach ($rentals as $rental)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-4 py-2 text-center font-semibold">
                                {{ $loop->iteration }}
                            </td>

                            <td class="border px-4 py-2">
                                <div class="font-bold text-blue-700">
                                    {{ $rental->nama }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $rental->user->email }}
                                </div>
                            </td>

                            <td class="border px-4 py-2 italic">
                                "{{ $rental->book->title }}"
                            </td>

                            <td class="border px-4 py-2 text-center">
                                <span class="badge bg-secondary">
                                    {{ $rental->book->stock }}
                                </span>
                            </td>

                            <td class="border px-4 py-2 text-sm">
                                {{ optional($rental->rented_at)->format('d M Y') ?? '-' }}
                            </td>

                            {{-- ACTION --}}
                            <td class="border px-4 py-2">
                                <div class="flex gap-2 justify-center">
                                    
                                    {{-- APPROVE --}}
                                    <button
                                        wire:click="approve({{ $rental->id }})"
                                        class="flex items-center gap-1
                                               px-3 py-1.5
                                               bg-green-600 hover:bg-green-700
                                               text-white text-sm font-semibold
                                               rounded shadow
                                               transition"
                                    >
                                        <i class="bi bi-check-lg"></i>
                                        Approve
                                    </button>

                                    {{-- REJECT --}}
                                    <button
                                        wire:click="reject({{ $rental->id }})"
                                        class="flex items-center gap-1
                                               px-3 py-1.5
                                               bg-red-600 hover:bg-red-700
                                               text-white text-sm font-semibold
                                               rounded shadow
                                               transition"
                                    >
                                        <i class="bi bi-x-lg"></i>
                                        Reject
                                    </button>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
