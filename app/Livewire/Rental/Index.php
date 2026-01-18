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

    // Mengembalikan buku
    public function returnBook($rentalId)
    {
        $rental = Rental::findOrFail($rentalId);

        // Pastikan rental milik user
        if ($rental->user_id !== Auth::id()) {
            session()->flash('error', 'Akses ditolak');
            return;
        }

        // Hanya bisa mengembalikan buku yang belum dikembalikan
        if ($rental->status === 'returned') {
            session()->flash('error', 'Buku sudah dikembalikan');
            return;
        }

        // Update status rental & tanggal kembali
        $rental->update([
            'returned_at' => now(),
            'status' => 'returned',
        ]);

        // Tambahkan stock buku kembali
        $rental->book->increment('stock');

        session()->flash('success', 'Buku berhasil dikembalikan');
        $this->dispatch('rentalUpdated');

        return redirect()->route('books.list');
    }

    public function render()
    {
        // Ambil rental milik user yang login, paling baru di atas (PAGINATION)
        $rentals = Rental::with('book')
            ->where('user_id', Auth::id())
            ->orderBy('rented_at', 'desc')
            ->paginate(6); 

        return view('livewire.rental.index', [
            'rentals' => $rentals
        ]);
    }
}
