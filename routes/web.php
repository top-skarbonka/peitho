<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FirmController;
use App\Http\Controllers\Auth\FirmAuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PublicClientController;

/*
|--------------------------------------------------------------------------
| STRONA GŁÓWNA
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return 'PEITHO DZIAŁA';
});

/*
|--------------------------------------------------------------------------
| PANEL FIRMY – AUTH
|--------------------------------------------------------------------------
*/
Route::get('/company/login', [FirmAuthController::class, 'showLoginForm'])
    ->name('company.login');

Route::post('/company/login', [FirmAuthController::class, 'login'])
    ->name('company.login.submit');

Route::get('/company/logout', [FirmAuthController::class, 'logout'])
    ->name('company.logout');

/*
|--------------------------------------------------------------------------
| PANEL FIRMY – DASHBOARD
|--------------------------------------------------------------------------
*/
Route::get('/company/dashboard', [FirmController::class, 'dashboard'])
    ->name('company.dashboard');

Route::get('/company/transactions', [FirmController::class, 'transactions'])
    ->name('company.transactions');

Route::get('/company/points', [FirmController::class, 'showPointsForm'])
    ->name('company.points.form');

Route::post('/company/points/add', [FirmController::class, 'addPoints'])
    ->name('company.points.add');

/*
|--------------------------------------------------------------------------
| KARTY LOJALNOŚCIOWE – PANEL FIRMY
|--------------------------------------------------------------------------
*/
Route::get('/company/loyalty-cards', [FirmController::class, 'loyaltyCards'])
    ->name('company.loyalty.cards');

Route::post('/company/loyalty-cards/{card}/stamp', [FirmController::class, 'addStamp'])
    ->name('company.loyalty.cards.stamp');

Route::post('/company/loyalty-cards/{card}/reset', [FirmController::class, 'resetCard'])
    ->name('company.loyalty.cards.reset');

Route::post('/company/loyalty-cards/{card}/redeem', [FirmController::class, 'redeemCard'])
    ->name('company.loyalty.cards.redeem');

/*
|--------------------------------------------------------------------------
| PANEL KLIENTA – PODGLĄD KARTY
|--------------------------------------------------------------------------
*/
Route::get('/client/loyalty-card', [ClientController::class, 'loyaltyCard'])
    ->name('client.loyalty.card');

/*
|--------------------------------------------------------------------------
| PUBLICZNY FORMULARZ ZAPISU KLIENTA (QR / LINK FIRMY)
|--------------------------------------------------------------------------
*/
Route::get('/join/{firm}', [PublicClientController::class, 'showForm'])
    ->name('public.join');

Route::post('/join/{firm}', [PublicClientController::class, 'submitForm'])
    ->name('public.join.submit');
Route::post(
    '/company/loyalty-cards/{card}/stamp',
    [\App\Http\Controllers\Firm\LoyaltyCardController::class, 'addStamp']
)->name('firm.loyalty-cards.stamp');
