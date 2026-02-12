<?php
namespace App\Livewire\Notification;

use Livewire\Component;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class Badge extends Component
{
    protected $listeners = ['notification-updated' => '$refresh'];

    public function render()
    {
        // Hanya hitung notifikasi yang belum dibaca AND masih relevan
        $count = Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->where(function ($q) {
                $q->whereNull('rental_id')
                  ->orWhereHas('rental', function ($qr) {
                      $qr->whereNull('returned_at');
                  });
            })
            ->count();

        return view('livewire.notification.badge', [
            'count' => $count,
        ]);
    }
}