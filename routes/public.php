<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicClientController;

/*
|--------------------------------------------------------------------------
| PUBLICZNA REJESTRACJA KARTY STAŁEGO KLIENTA
|--------------------------------------------------------------------------
| Link generowany per firma:
| /register/card/{firm}
*/

Route::get('/register/card/{firm}', [PublicClientController::class, 'showForm'])
    ->name('card.register.form');

Route::post('/register/card/{firm}', [PublicClientController::class, 'submitForm'])
    ->name('card.register.store');
