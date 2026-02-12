<?php
namespace App\Livewire\Notification;

use Livewire\Component;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On; // Tambahkan ini

class Index extends Component
{
    // Gunakan Attribute On untuk listener di Livewire 3
    #[On('open-drawer')]
    public function openDrawer()
    {
        // Method ini bisa dikosongkan jika hanya ingin Alpine yang bekerja,
        // tapi berguna jika Anda ingin log sesuatu atau fetch data terbaru saat drawer buka.
    }

    // Global event agar komponen ini bisa menyegarkan ketika notifikasi berubah
    protected $listeners = ['notification-updated' => '$refresh'];

    public function markAsReadAndRedirect($notificationId)
    {
        $notification = Notification::where('id', $notificationId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $notification->update(['is_read' => true]);

        // Emit ke komponen badge
        $this->dispatch('notification-updated');

        return redirect()->to('/rentals');
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $this->dispatch('notification-updated');
    }

    public function render()
    {
        // Hanya tampilkan notifikasi yang relevan: bukan terkait rental yang sudah dikembalikan
        $notifications = Notification::where('user_id', Auth::id())
            ->where(function ($q) {
                $q->whereNull('rental_id')
                  ->orWhereHas('rental', function ($qr) {
                      $qr->whereNull('returned_at');
                  });
            })
            ->latest()
            ->take(20)
            ->get();

        return view('livewire.notification.index', [
            'notifications' => $notifications,
        ]);
    }
}