<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Rental;

class RecentRentals extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    // Dengarkan event dari halaman rental
    protected $listeners = ['rentalUpdated' => '$refresh'];

    public function render()
    {
        return view('livewire.dashboard.recent-rentals', [
            'rentals' => Rental::with('book','user')
                ->orderBy('updated_at', 'desc') // paling baru di atas
                ->paginate(5) // ✅ pagination (FIX tenggelam)
        ]);
    }
}
