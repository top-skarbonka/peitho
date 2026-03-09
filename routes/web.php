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
use App\Http\Controllers\Auth\ClientSetPasswordController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PublicClientController;
use App\Http\Controllers\PublicPassController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminFirmController;
use App\Http\Controllers\Admin\ConsentExportController;
use App\Http\Middleware\EnsureSubscriptionIsActive;


/*
|--------------------------------------------------------------------------
| STRONA GŁÓWNA
|--------------------------------------------------------------------------
*/

Route::get('/', fn () => 'PEITHO DZIAŁA');


/*
|--------------------------------------------------------------------------
| LOGIN ALIAS
|--------------------------------------------------------------------------
*/

Route::get('/login', fn () => redirect()->route('company.login'))
    ->name('login');


/*
|--------------------------------------------------------------------------
| PANEL FIRMY — LOGIN
|--------------------------------------------------------------------------
*/

Route::prefix('company')->group(function () {

    Route::get('/login', [FirmAuthController::class, 'showLoginForm'])
        ->name('company.login');

    Route::post('/login', [FirmAuthController::class, 'login'])
        ->name('company.login.submit');

    Route::post('/logout', [FirmAuthController::class, 'logout'])
        ->name('company.logout');
});


/*
|--------------------------------------------------------------------------
| PANEL FIRMY — SaaS CORE
|--------------------------------------------------------------------------
*/

Route::prefix('company')
    ->middleware(['auth:company', EnsureSubscriptionIsActive::class])
    ->group(function () {

        Route::get('/dashboard', [FirmController::class, 'dashboard'])
            ->name('company.dashboard');

        Route::get('/transactions', [FirmController::class, 'transactions'])
            ->name('company.transactions');

        Route::get('/points', [FirmController::class, 'showPointsForm'])
            ->name('company.points.form');

        Route::post('/points', [FirmController::class, 'addPoints'])
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

        Route::get('/scan', fn () => view('firm.scan.index'))
            ->name('company.scan.form');

        Route::post('/scan', [FirmController::class, 'scanQr'])
            ->name('company.scan');


        /*
        |--------------------------------------------------------------------------
        | KARNETY
        |--------------------------------------------------------------------------
        */

        Route::get('/pass-types', [FirmController::class, 'passTypes'])
            ->name('company.pass_types');

        Route::post('/pass-types', [FirmController::class, 'storePassType'])
            ->name('company.pass_types.store');

        Route::get('/passes/issue', [FirmController::class, 'issuePassForm'])
            ->name('company.passes.issue_form');

        Route::post('/passes/issue', [FirmController::class, 'issuePass'])
            ->name('company.passes.issue');

        Route::get('/passes', [FirmController::class, 'issuedPasses'])
            ->name('company.passes.index');
    });


/*
|--------------------------------------------------------------------------
| PUBLIC — REJESTRACJA
|--------------------------------------------------------------------------
*/

Route::get('/register/card/{token}', [PublicClientController::class, 'showRegisterForm'])
    ->name('client.register.form');

Route::post('/register/card/{token}', [PublicClientController::class, 'register'])
    ->name('client.register.submit');

Route::get('/join/{slug}', [PublicClientController::class, 'showRegisterFormByFirm'])
    ->name('client.register.by_firm');

Route::post('/join/{slug}', [PublicClientController::class, 'registerByFirm'])
    ->name('client.register.by_firm.submit');


/*
|--------------------------------------------------------------------------
| PUBLIC — WEJŚCIE NA KARNET (QR)
|--------------------------------------------------------------------------
*/

Route::get('/pass/{slug}/{token}', [PublicPassController::class, 'showPhoneForm'])
    ->name('public-pass.form');

Route::post('/pass/{slug}/{token}/send-otp', [PublicPassController::class, 'sendOtp'])
    ->name('public-pass.send-otp');

Route::post('/pass/{slug}/{token}/verify-otp', [PublicPassController::class, 'verifyOtp'])
    ->name('public-pass.verify-otp');


/*
|--------------------------------------------------------------------------
| PANEL KLIENTA
|--------------------------------------------------------------------------
*/

Route::prefix('client')->group(function () {

    Route::get('/login', [ClientAuthController::class, 'showLoginForm'])
        ->name('client.login');

    Route::post('/login', [ClientAuthController::class, 'login'])
        ->name('client.login.submit');

    Route::post('/logout', [ClientAuthController::class, 'logout'])
        ->name('client.logout');

    Route::get('/set-password/{token}', [ClientSetPasswordController::class, 'show'])
        ->name('client.set_password.show');

    Route::post('/set-password/{token}', [ClientSetPasswordController::class, 'store'])
        ->name('client.set_password.store');

    Route::middleware('auth:client')->group(function () {

        Route::get('/dashboard', [ClientController::class, 'dashboard'])
            ->name('client.dashboard');

        Route::get('/consents', [ClientController::class, 'consents'])
            ->name('client.consents');

        Route::post('/consents/{card}', [ClientController::class, 'updateConsent'])
            ->name('client.consents.update');

        Route::get('/loyalty-card', [ClientController::class, 'loyaltyCard'])
            ->name('client.loyalty.card');

        Route::get('/loyalty-card/{card}', [ClientController::class, 'showCard'])
            ->name('client.loyalty.card.show');
    });
});


/*
|--------------------------------------------------------------------------
| ADMIN — LOGIN
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
| ADMIN — PANEL
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware('admin.simple')
    ->group(function () {

        Route::get('/', fn () => redirect()->route('admin.firms.index'))
            ->name('admin.dashboard');

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

        Route::get('/firms/{firm}/activity', [AdminFirmController::class, 'activity'])
            ->name('admin.firms.activity');

        Route::post('/firms/{firm}/extend-30', [AdminFirmController::class, 'extend30'])
            ->name('admin.firms.extend30');

        Route::post('/firms/{firm}/extend-365', [AdminFirmController::class, 'extend365'])
            ->name('admin.firms.extend365');

        Route::post('/firms/{firm}/block', [AdminFirmController::class, 'block'])
            ->name('admin.firms.block');

        Route::get('/consents/export/csv', [ConsentExportController::class, 'exportCsv'])
            ->name('admin.consents.export.csv');
    });
