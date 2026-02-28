<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicPassController;

/*
|--------------------------------------------------------------------------
| PUBLIC PASS (QR → OTP → ODJĘCIE WEJŚCIA)
|--------------------------------------------------------------------------
*/

Route::prefix('public-pass/{slug}/{token}')->group(function () {

    Route::post('/send-otp', [PublicPassController::class, 'sendOtp'])
        ->name('api.public-pass.send-otp');

    Route::post('/verify-otp', [PublicPassController::class, 'verifyOtp'])
        ->name('api.public-pass.verify-otp');

});
