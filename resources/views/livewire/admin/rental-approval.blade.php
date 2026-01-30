<div class="p-4 text-zinc-800 dark:text-zinc-100">

    <h1 class="text-2xl font-bold mb-4 text-zinc-900 dark:text-zinc-100">
        Rental Pending
    </h1>

    {{-- BOOTSTRAP ALERT --}}
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($rentals->isEmpty())
        <p class="text-gray-600 dark:text-gray-400">
            Tidak ada permintaan sewa.
        </p>
    @else
        <div class="overflow-x-auto">
            <table class="w-full table-auto border border-gray-300 dark:border-zinc-700">
                <thead>
                    <tr class="bg-gray-100 dark:bg-zinc-700">
                        <th class="border px-2 py-1 text-left">ID</th>
                        <th class="border px-2 py-1 text-left">User</th>
                        <th class="border px-2 py-1 text-left">Buku</th>
                        <th class="border px-2 py-1 text-left">Stock Buku</th>
                        <th class="border px-2 py-1 text-left">Tanggal Rental</th>
                        <th class="border px-2 py-1 text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rentals as $rental)
                        <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800">
                            <td class="border px-2 py-1">
                                {{ $rental->id }}
                            </td>
                            <td class="border px-2 py-1">
                                {{ $rental->nama }} ({{ $rental->user->email }})
                            </td>
                            <td class="border px-2 py-1">
                                {{ $rental->book->title }}
                            </td>
                            <td class="border px-2 py-1">
                                {{ $rental->book->stock }}
                            </td>
                            <td class="border px-2 py-1">
                                {{ optional($rental->rented_at)->format('d M Y H:i') ?? '-' }}
                            </td>
                            <td class="border px-2 py-1 flex gap-2">
                                <button
                                    wire:click="approve({{ $rental->id }})"
                                    class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600">
                                    Approve
                                </button>
                                <button
                                    wire:click="reject({{ $rental->id }})"
                                    class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">
                                    Reject
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>
