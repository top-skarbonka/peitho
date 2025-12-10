<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FirmController;
use App\Http\Controllers\Auth\FirmAuthController;
use App\Http\Controllers\Auth\AdminAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes – Peitho
|--------------------------------------------------------------------------
*/

// STRONA GŁÓWNA TESTOWA
Route::get('/', function () {
    return "PEITHO DZIAŁA — strona główna";
});

/*
|--------------------------------------------------------------------------
| PANEL FIRMY
|--------------------------------------------------------------------------
*/

Route::get('/company/login', [FirmAuthController::class, 'showLoginForm'])->name('company.login');
Route::post('/company/login', [FirmAuthController::class, 'login'])->name('company.login.submit');

Route::get('/company/dashboard', [FirmController::class, 'dashboard'])->name('company.dashboard');


/*
|--------------------------------------------------------------------------
| SKANOWANIE QR
|--------------------------------------------------------------------------
*/

Route::get('/scan/{code}', [FirmController::class, 'scan'])->name('firm.scan');


/*
|--------------------------------------------------------------------------
| KARTY LOJALNOŚCIOWE
|--------------------------------------------------------------------------
*/

Route::post('/firm/card/{id}/add-stamp', [FirmController::class, 'addStamp'])->name('firm.card.addStamp');
Route::post('/firm/card/{id}/reset', [FirmController::class, 'resetCard'])->name('firm.card.reset');


/*
|--------------------------------------------------------------------------
| VOUCHERY
|--------------------------------------------------------------------------
*/

Route::post('/firm/voucher/{id}/use', [FirmController::class, 'useVoucher'])->name('firm.voucher.use');
