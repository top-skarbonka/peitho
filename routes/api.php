<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicPassController;

/*
|--------------------------------------------------------------------------
| API ROUTES – PUBLIC QR (KARNETY)
|--------------------------------------------------------------------------
|
| Publiczny endpoint do obsługi karnetów:
| - skan QR firmy
| - podanie telefonu
| - wysłanie OTP
| - weryfikacja OTP
| - potrącenie wejścia
|
| BEZ sesji
| BEZ CSRF
| BEZ redirectów
| Czysty JSON
|
*/

Route::prefix('c')->group(function () {

    Route::get('/{slug}/{token}', [PublicPassController::class, 'showPhoneForm'])
        ->name('api.passes.phone');

    Route::post('/{slug}/{token}/otp', [PublicPassController::class, 'sendOtp'])
        ->name('api.passes.otp');

    Route::post('/{slug}/{token}/verify', [PublicPassController::class, 'verifyOtp'])
        ->name('api.passes.verify');

});
