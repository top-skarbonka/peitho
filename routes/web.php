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

        /*
        | NOWE ROUTY DODAWANIA PUNKTÓW KLIENTOWI
        */

        Route::get('/points/add-client', [FirmController::class, 'showAddClientPointsForm'])
            ->name('company.points.client.form');

        Route::post('/points/add-client', [FirmController::class, 'storeClientPoints'])
            ->name('company.points.client.store');

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
