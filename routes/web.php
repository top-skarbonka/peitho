<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CONTROLLERS
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\FirmController;
use App\Http\Controllers\Auth\FirmAuthController;

use App\Http\Controllers\Auth\ClientAuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PublicClientController;

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminFirmController;
use App\Http\Controllers\Admin\ConsentExportController;

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
| ALIAS /login (Laravel default)
|--------------------------------------------------------------------------
*/
Route::get('/login', function () {
    return redirect()->route('company.login');
})->name('login');

/*
|--------------------------------------------------------------------------
| PANEL FIRMY – LOGOWANIE / WYLOGOWANIE
|--------------------------------------------------------------------------
*/
Route::get('/company/login', [FirmAuthController::class, 'showLoginForm'])
    ->name('company.login');

Route::post('/company/login', [FirmAuthController::class, 'login'])
    ->name('company.login.submit');

Route::post('/company/logout', [FirmAuthController::class, 'logout'])
    ->name('company.logout');

/*
|--------------------------------------------------------------------------
| PANEL FIRMY – ZABEZPIECZONY
|--------------------------------------------------------------------------
*/
Route::prefix('company')
    ->middleware('auth:company')
    ->group(function () {

        Route::get('/dashboard', [FirmController::class, 'dashboard'])
            ->name('company.dashboard');

        Route::get('/transactions', [FirmController::class, 'transactions'])
            ->name('company.transactions');

        Route::get('/points', [FirmController::class, 'showPointsForm'])
            ->name('company.points.form');

        Route::post('/points/add', [FirmController::class, 'addPoints'])
            ->name('company.points.add');

        Route::get('/loyalty-cards', [FirmController::class, 'loyaltyCards'])
            ->name('company.loyalty.cards');

        Route::post('/loyalty-cards/{card}/stamp', [FirmController::class, 'addStamp'])
            ->name('company.loyalty.cards.stamp');

        Route::post('/loyalty-cards/{card}/reset', [FirmController::class, 'resetCard'])
            ->name('company.loyalty.cards.reset');

        Route::post('/loyalty-cards/{card}/redeem', [FirmController::class, 'redeemCard'])
            ->name('company.loyalty.cards.redeem');

        Route::post('/loyalty-cards/generate-link', [FirmController::class, 'generateRegistrationLink'])
            ->name('company.loyalty.cards.generate');
    });

/*
|--------------------------------------------------------------------------
| PUBLIC – REJESTRACJA KLIENTA (TOKEN)
|--------------------------------------------------------------------------
*/
Route::get('/register/card/{token}', [PublicClientController::class, 'showRegisterForm'])
    ->name('client.register.form');

Route::post('/register/card/{token}', [PublicClientController::class, 'register'])
    ->name('client.register.submit');

/*
|--------------------------------------------------------------------------
| PUBLIC – STAŁY LINK (QR)
|--------------------------------------------------------------------------
*/
Route::get('/join/{firm_id}', [PublicClientController::class, 'showRegisterFormByFirm'])
    ->name('client.register.by_firm');

Route::post('/join/{firm_id}', [PublicClientController::class, 'registerByFirm'])
    ->name('client.register.by_firm.submit');

/*
|--------------------------------------------------------------------------
| LOGOWANIE KLIENTA
|--------------------------------------------------------------------------
*/
Route::get('/client/login', [ClientAuthController::class, 'showLoginForm'])
    ->name('client.login');

Route::post('/client/login', [ClientAuthController::class, 'login'])
    ->name('client.login.submit');

Route::post('/client/logout', [ClientAuthController::class, 'logout'])
    ->name('client.logout');

/*
|--------------------------------------------------------------------------
| PANEL KLIENTA
|--------------------------------------------------------------------------
*/
Route::middleware('auth:client')->group(function () {

    Route::get('/client/loyalty-card', [ClientController::class, 'loyaltyCard'])
        ->name('client.loyalty.card');

});

/*
|--------------------------------------------------------------------------
| ADMIN – LOGOWANIE
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {

    Route::get('/login', [AdminAuthController::class, 'show'])
        ->name('admin.login');

    Route::post('/login', [AdminAuthController::class, 'login'])
        ->name('admin.login.submit');

    Route::post('/logout', [AdminAuthController::class, 'logout'])
        ->name('admin.logout');
});

/*
|--------------------------------------------------------------------------
| ADMIN – PANEL (ZABEZPIECZONY)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->middleware(['admin.simple'])
    ->group(function () {

        Route::get('/firms', [AdminFirmController::class, 'index'])
            ->name('admin.firms.index');

        Route::get('/firms/create', [AdminFirmController::class, 'create'])
            ->name('admin.firms.create');

        Route::post('/firms', [AdminFirmController::class, 'store'])
            ->name('admin.firms.store');

        Route::get('/firms/{firm}/edit', [AdminFirmController::class, 'edit'])
            ->name('admin.firms.edit');

        Route::put('/firms/{firm}', [AdminFirmController::class, 'update'])
            ->name('admin.firms.update');

        /*
        |--------------------------------------------------------------------------
        | EKSPORT ZGÓD – UODO (CSV)
        |--------------------------------------------------------------------------
        */
        Route::post(
            '/consents/export/csv',
            [ConsentExportController::class, 'exportCsv']
        )->name('admin.consents.export.csv');

    });
