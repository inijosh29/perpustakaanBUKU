<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

// ================= LIVEWIRE =================
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;

use App\Livewire\Book\Index as BookIndex;
use App\Livewire\Rental\Index as RentalIndex;
use App\Livewire\Admin\RentalApproval;
use App\Livewire\Notification\Index as NotificationIndex;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // ================= SETTINGS =================
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)
        ->name('profile.edit');

    Route::get('settings/password', Password::class)
        ->name('user-password.edit');

    Route::get('settings/appearance', Appearance::class)
        ->name('appearance.edit');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                && Features::optionEnabled(
                    Features::twoFactorAuthentication(),
                    'confirmPassword'
                ),
                ['password.confirm'],
                []
            )
        )
        ->name('two-factor.show');

    // ================= BUKU =================
    Route::get('/books', BookIndex::class)
        ->name('books.index');

    // ================= RENTAL (USER) =================
    Route::get('/rentals', RentalIndex::class)
        ->name('rentals');

    // ================= NOTIFICATION =================
    Route::get('/notifications', NotificationIndex::class)
        ->name('notifications.index');
});

/*
|--------------------------------------------------------------------------
| ADMIN ONLY
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin/rentals', RentalApproval::class)
        ->name('admin.rentals');

});
