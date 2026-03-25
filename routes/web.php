<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

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

Route::get('/', fn () => 'PEITHO DZIAŁA');

Route::get('/login', fn () => redirect()->route('company.login'))->name('login');

Route::prefix('company')->group(function () {
    Route::get('/login', [FirmAuthController::class, 'showLoginForm'])->name('company.login');
    Route::post('/login', [FirmAuthController::class, 'login'])->name('company.login.submit');
    Route::post('/logout', [FirmAuthController::class, 'logout'])->name('company.logout');
});

Route::prefix('company')
    ->middleware(['auth:company', EnsureSubscriptionIsActive::class])
    ->group(function () {

        Route::get('/dashboard', [FirmController::class, 'dashboard'])->name('company.dashboard');
        Route::get('/transactions', [FirmController::class, 'transactions'])->name('company.transactions');

        Route::get('/points', [FirmController::class, 'showPointsForm'])->name('company.points.form');
        Route::post('/points', [FirmController::class, 'addPoints'])->name('company.points.add');

        Route::get('/points/add-client', [FirmController::class, 'showAddClientPointsForm'])->name('company.points.client.form');
        Route::post('/points/add-client', [FirmController::class, 'storeClientPoints'])->name('company.points.client.store');

        Route::get('/loyalty-cards', [FirmController::class, 'loyaltyCards'])->name('company.loyalty.cards');

        Route::post('/loyalty-cards/{card}/stamp', [FirmController::class, 'addStamp'])->name('company.loyalty.cards.stamp');
        Route::post('/loyalty-cards/{card}/reset', [FirmController::class, 'resetCard'])->name('company.loyalty.cards.reset');
        Route::post('/loyalty-cards/{card}/redeem', [FirmController::class, 'redeemCard'])->name('company.loyalty.cards.redeem');

        Route::post('/loyalty-cards/generate-link', [FirmController::class, 'generateRegistrationLink'])->name('company.loyalty.cards.generate');

        Route::get('/scan', fn () => view('firm.scan.index'))->name('company.scan.form');
        Route::post('/scan', [FirmController::class, 'scanQr'])->name('company.scan');

        Route::get('/pass-types', [FirmController::class, 'passTypes'])->name('company.pass_types');
        Route::post('/pass-types', [FirmController::class, 'storePassType'])->name('company.pass_types.store');

        Route::get('/passes/issue', [FirmController::class, 'issuePassForm'])->name('company.passes.issue_form');
        Route::post('/passes/issue', [FirmController::class, 'issuePass'])->name('company.passes.issue');

        Route::get('/passes', [FirmController::class, 'issuedPasses'])->name('company.passes.index');

        Route::post('/redeem', [FirmController::class, 'redeemPoints'])
            ->name('company.points.redeem');
    });

/*
|--------------------------------------------------------------------------
| 🔥 API — PUNKTY + REWARDS + OSZCZĘDNOŚCI
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:company'])->get('/api/client-points', function (\Illuminate\Http\Request $request) {

    $phone = preg_replace('/\D+/', '', $request->phone);

    if (str_starts_with($phone, '48') && strlen($phone) === 11) {
        $phone = substr($phone, 2);
    }

    $client = DB::table('clients')->where('phone', $phone)->first();

    if (!$client) {
        return response()->json(['success' => false]);
    }

    $firm = auth()->guard('company')->user();

    if (!$firm) {
        return response()->json(['success' => false]);
    }

    $points = DB::table('client_points')
        ->where('client_id', $client->id)
        ->where('firm_id', $firm->id)
        ->value('points') ?? 0;

    $settings = DB::table('program_settings')
        ->where('firm_id', $firm->id)
        ->first();

    $pointsPerCurrency = $settings->points_per_currency ?? 10;

    $rewards = DB::table('point_rewards')
        ->where('firm_id', $firm->id)
        ->orderBy('points_required')
        ->get()
        ->values();

    $availableRewards = $rewards->filter(fn($r) => $points >= $r->points_required)->values();

    $nextReward = $rewards->first(fn($r) => $points < $r->points_required);

    /*
    |--------------------------------------------------------------------------
    | 🔥 NOWE — OSZCZĘDNOŚCI (REALNE)
    |--------------------------------------------------------------------------
    */

    $usedPoints = DB::table('client_point_logs')
        ->where('client_id', $client->id)
        ->where('firm_id', $firm->id)
        ->where('points', '<', 0)
        ->sum('points');

    // points są ujemne → robimy dodatnie
    $usedPoints = abs($usedPoints);

    // przeliczamy na zł wg ustawień firmy
    $totalSaved = $usedPoints / $pointsPerCurrency;

    return response()->json([
        'success' => true,
        'points' => $points,
        'client_id' => $client->id,
        'rewards' => $availableRewards,
        'next_reward' => $nextReward,
        'points_per_currency' => $pointsPerCurrency,
        'total_saved' => round($totalSaved, 2),
    ]);
});
