<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Rental;
use Carbon\Carbon;

class RentalApproval extends Component
{
    public function approve($rentalId)
    {
        $rental = Rental::with('book')->findOrFail($rentalId);

        // hanya jika status pending
        if ($rental->status !== 'pending') return;

        // cek stock buku
        if ($rental->book->stock <= 0) {
            session()->flash('error', 'Stock buku tidak cukup untuk disetujui.');
            return;
        }

        // SET WAKTU RENTAL & BATAS WAKTU
        $rental->update([
            'status'    => 'approved',
            'rented_at' => now(),
            'due_date'  => now()->addMinutes(1), // ⏰ TEST 3 MENIT
        ]);

        // kurangi stock buku
        $rental->book->decrement('stock');

        session()->flash('success', "Rental ID {$rental->id} disetujui.");
    }

    public function reject($rentalId)
    {
        $rental = Rental::findOrFail($rentalId);

        if ($rental->status !== 'pending') return;

        $rental->update([
            'status' => 'rejected',
        ]);

        session()->flash('success', "Rental ID {$rental->id} ditolak.");
    }

    public function render()
    {
        $rentals = Rental::with(['book', 'user'])
            ->where('status', 'pending')
            ->orderBy('rented_at', 'asc')
            ->get();

        return view('livewire.admin.rental-approval', [
            'rentals' => $rentals,
        ]);
    }
}
