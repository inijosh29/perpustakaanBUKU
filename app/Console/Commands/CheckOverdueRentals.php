<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Rental;
use App\Models\Notification;
use Carbon\Carbon;

class CheckOverdueRentals extends Command
{
    protected $signature = 'app:check-overdue-rentals';
    protected $description = 'Membuat notifikasi jika rental buku sudah melewati batas waktu';

    public function handle()
    {
        // Ambil rental yang BELUM dikembalikan & SUDAH lewat jatuh tempo (WAKTU)
        $rentals = Rental::whereNull('returned_at')
            ->where('due_date', '<', now())
            ->get();

        foreach ($rentals as $rental) {

            // Cegah notifikasi dobel
            $alreadyNotified = Notification::where('user_id', $rental->user_id)
                ->where('rental_id', $rental->id)
                ->where('is_read', false)
                ->exists();

            if (! $alreadyNotified) {
                Notification::create([
                    'user_id'   => $rental->user_id,
                    'rental_id' => $rental->id,
                    'message'   => "⏰ Waktu peminjaman buku '{$rental->book->title}' telah habis. Segera kembalikan buku.",
                ]);
            }
        }

        $this->info('Notifikasi overdue berhasil dicek.');
    }
}
