<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FirmController;
use App\Http\Controllers\Auth\FirmAuthController;
use App\Http\Controllers\Auth\AdminAuthController;

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
| PANEL FIRMY – logowanie i dashboard
|--------------------------------------------------------------------------
*/

Route::get('/company/login', [FirmAuthController::class, 'showLoginForm'])
    ->name('company.login');

Route::post('/company/login', [FirmAuthController::class, 'login'])
    ->name('company.login.submit');

Route::get('/company/dashboard', [FirmController::class, 'dashboard'])
    ->name('company.dashboard');

/*
|--------------------------------------------------------------------------
| PUNKTY LOJALNOŚCIOWE – formularz + zapis
|--------------------------------------------------------------------------
|
| Firma wprowadza kwotę → system liczy punkty i dodaje klientowi
|--------------------------------------------------------------------------
*/

// formularz „Dodaj punkty”
Route::get('/company/points', [FirmController::class, 'showPointsForm'])
    ->name('company.points.form');

// zapis punktów (submit formularza)
Route::post('/company/points/add', [FirmController::class, 'addPoints'])
    ->name('company.points.add');


/*
|--------------------------------------------------------------------------
| SKANOWANIE QR
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
