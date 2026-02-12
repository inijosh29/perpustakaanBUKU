<?php

namespace App\Livewire\Rental;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Rental;
use App\Models\Notification; // <-- add Notification model
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

        //  hanya boleh kembalikan jika SUDAH DISETUJUI
        if ($rental->status !== 'approved') {
            session()->flash('error', 'Buku tidak bisa dikembalikan');
            return;
        }

        //  kembalikan stock buku
        $rental->book->increment('stock');

        // update rental
        $rental->update([
            'status' => 'returned',
            'returned_at' => now(),
        ]);

        // Hapus notifikasi yang terkait dengan rental ini sehingga notifikasi hilang ketika buku dikembalikan
        Notification::where('rental_id', $rental->id)
            ->where('user_id', Auth::id())
            ->delete();

        // Beri tahu komponen notifikasi untuk menyegarkan (badge + drawer)
        $this->dispatch('notification-updated');

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
