<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FirmController;
use App\Http\Controllers\Auth\FirmAuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PublicClientController;

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminFirmController;

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
| ALIAS login (żeby Laravel nie wariował)
|--------------------------------------------------------------------------
*/
Route::get('/login', function () {
    return redirect()->route('company.login');
})->name('login');

/*
|--------------------------------------------------------------------------
| PANEL FIRMY – LOGOWANIE
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
| PANEL FIRMY – BEZ middleware (NA RAZIE!)
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
| PANEL KLIENTA
|--------------------------------------------------------------------------
*/
Route::get('/client/loyalty-card', [ClientController::class, 'loyaltyCard'])
    ->name('client.loyalty.card');

/*
|--------------------------------------------------------------------------
| PUBLIC JOIN
|--------------------------------------------------------------------------
*/
Route::get('/join/{firm}', [PublicClientController::class, 'showForm'])
    ->name('public.join');

Route::post('/join/{firm}', [PublicClientController::class, 'submitForm'])
    ->name('public.join.submit');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {

    Route::get('/login', [AdminAuthController::class, 'show'])
        ->name('admin.login');

    Route::post('/login', [AdminAuthController::class, 'login'])
        ->name('admin.login.submit');

    Route::post('/logout', [AdminAuthController::class, 'logout'])
        ->name('admin.logout');

    Route::middleware('admin.simple')->group(function () {

        Route::get('/firms/create', [AdminFirmController::class, 'create'])
            ->name('admin.firms.create');

        Route::post('/firms', [AdminFirmController::class, 'store'])
            ->name('admin.firms.store');
    });
});
