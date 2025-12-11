<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FirmController;
use App\Http\Controllers\Auth\FirmAuthController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\ClientController;

/*
|--------------------------------------------------------------------------
| Strona główna – test
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return "PEITHO DZIAŁA — strona główna";
});


/*
|--------------------------------------------------------------------------
| PANEL FIRMY – logowanie, wylogowanie i dashboard
|--------------------------------------------------------------------------
*/

Route::get('/company/login', [FirmAuthController::class, 'showLoginForm'])
    ->name('company.login');

Route::post('/company/login', [FirmAuthController::class, 'login'])
    ->name('company.login.submit');

Route::get('/company/logout', [FirmAuthController::class, 'logout'])
    ->name('company.logout');

Route::get('/company/dashboard', [FirmController::class, 'dashboard'])
    ->name('company.dashboard');


/*
|--------------------------------------------------------------------------
| PUNKTY LOJALNOŚCIOWE – formularz i zapis
|--------------------------------------------------------------------------
*/

Route::get('/company/points', [FirmController::class, 'showPointsForm'])
    ->name('company.points.form');

Route::post('/company/points/add', [FirmController::class, 'addPoints'])
    ->name('company.points.add');


/*
|--------------------------------------------------------------------------
| SKANOWANIE QR – karty i vouchery
|--------------------------------------------------------------------------
*/

Route::get('/scan/{code}', [FirmController::class, 'scan'])
    ->name('firm.scan');


/*
|--------------------------------------------------------------------------
| KARTY LOJALNOŚCIOWE – naklejki
|--------------------------------------------------------------------------
*/

Route::post('/firm/card/{id}/add-stamp', [FirmController::class, 'addStamp'])
    ->name('firm.card.addStamp');

Route::post('/firm/card/{id}/reset', [FirmController::class, 'resetCard'])
    ->name('firm.card.reset');


/*
|--------------------------------------------------------------------------
| VOUCHERY
|--------------------------------------------------------------------------
*/

Route::post('/firm/voucher/{id}/use', [FirmController::class, 'useVoucher'])
    ->name('firm.voucher.use');


/*
|--------------------------------------------------------------------------
| HISTORIA TRANSAKCJI – PANEL FIRMY
|--------------------------------------------------------------------------
*/

Route::get('/company/transactions', [FirmController::class, 'transactions'])
    ->name('company.transactions');


/*
|--------------------------------------------------------------------------
| HISTORIA TRANSAKCJI – PANEL KLIENTA
|--------------------------------------------------------------------------
*/

Route::get('/client/transactions', [ClientController::class, 'transactions'])
    ->name('client.transactions');
