<?php

namespace App\Livewire\Rental;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Rental;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public function returnBook($rentalId)
    {
        $rental = Rental::with('book')->findOrFail($rentalId);

        // keamanan
        if ($rental->user_id !== Auth::id()) {
            session()->flash('error', 'Akses ditolak');
            return;
        }

        // ✅ hanya boleh kembalikan jika SUDAH DISETUJUI
        if ($rental->status !== 'approved') {
            session()->flash('error', 'Buku tidak bisa dikembalikan');
            return;
        }

        // ✅ kembalikan stock buku
        $rental->book->increment('stock');

        // update rental
        $rental->update([
            'status' => 'returned',
            'returned_at' => now(),
        ]);

        session()->flash('success', 'Buku berhasil dikembalikan');
    }

    public function render()
    {
        $rentals = Rental::with(['book', 'user'])
            ->where('user_id', Auth::id())
            ->orderByDesc('rented_at')
            ->paginate(6);

        return view('livewire.rental.index', compact('rentals'));
    }
}
