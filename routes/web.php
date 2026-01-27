<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use App\Livewire\Book\Index as BookIndex;
use App\Livewire\Rental\Index as RentalIndex;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Twilio\Rest\Client;

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {

    // ================= SETTINGS =================
    Route::redirect('settings', 'settings/profile');
    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

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
    Route::get('/books', BookIndex::class)->name('books.index');

    // ================= RENTAL =================
    Route::get('/rentals', RentalIndex::class)->name('rentals');

    // ================= TEST WHATSAPP (TWILIO) =================
    Route::get('/test-wa', function () {

        $client = new Client(
            env('TWILIO_SID'),
            env('TWILIO_AUTH_TOKEN')
        );

        $client->messages->create(
            'whatsapp:' . env('TWILIO_WHATSAPP_TO'),
            [
                'from' => 'whatsapp:' . env('TWILIO_WHATSAPP_FROM'),
                'body' => "🔥 TEST BERHASIL\nPesan ini dikirim dari Laravel via Twilio"
            ]
        );

        return 'WhatsApp terkirim';
    });

});
