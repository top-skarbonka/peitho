<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Firm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PublicPassController extends Controller
{
    public function showPhoneForm(string $slug, string $token)
    {
        $firm = Firm::where('slug', $slug)->first();

        if (!$firm) {
            return response('Nieprawidłowa firma.', 404);
        }

        if (!$firm->pass_qr_token || $firm->pass_qr_token !== $token) {
            return response('Nieprawidłowy token QR.', 403);
        }

        return response("OK. Firma: {$firm->name}. Podaj numer telefonu.", 200);
    }

    public function sendOtp(Request $request, string $slug, string $token)
    {
        $request->validate([
            'phone' => ['required', 'string', 'min:6', 'max:32'],
        ]);

        $firm = Firm::where('slug', $slug)->first();
        if (!$firm) {
            return response('Nieprawidłowa firma.', 404);
        }

        if (!$firm->pass_qr_token || $firm->pass_qr_token !== $token) {
            return response('Nieprawidłowy token QR.', 403);
        }

        $phone = $request->input('phone');

        $client = Client::where('phone', $phone)->first();
        if (!$client) {
            return response('Klient nie istnieje.', 404);
        }

        $otp = str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);
        $expiresAt = now()->addMinutes(3);

        DB::table('otp_codes')
            ->where('firm_id', $firm->id)
            ->where('phone', $phone)
            ->whereNull('used_at')
            ->whereNull('revoked_at')
            ->update([
                'revoked_at' => now(),
                'updated_at' => now(),
            ]);

        DB::table('otp_codes')->insert([
            'firm_id' => $firm->id,
            'client_id' => $client->id,
            'phone' => $phone,
            'code_hash' => Hash::make($otp),
            'attempts' => 0,
            'expires_at' => $expiresAt,
            'used_at' => null,
            'revoked_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'otp_dev' => $otp,
            'expires_at' => $expiresAt->toDateTimeString(),
        ]);
    }

    public function verifyOtp(Request $request, string $slug, string $token)
    {
        $request->validate([
            'phone' => ['required', 'string', 'min:6', 'max:32'],
            'otp' => ['required', 'digits:4'],
        ]);

        $firm = Firm::where('slug', $slug)->first();
        if (!$firm) {
            return response('Nieprawidłowa firma.', 404);
        }

        if (!$firm->pass_qr_token || $firm->pass_qr_token !== $token) {
            return response('Nieprawidłowy token QR.', 403);
        }

        $phone = $request->input('phone');
        $otp = $request->input('otp');

        $row = DB::table('otp_codes')
            ->where('firm_id', $firm->id)
            ->where('phone', $phone)
            ->whereNull('used_at')
            ->whereNull('revoked_at')
            ->orderByDesc('id')
            ->first();

        if (!$row) {
            return response('Brak aktywnego kodu.', 404);
        }

        if (now()->greaterThan($row->expires_at)) {
            return response('Kod wygasł.', 422);
        }

        if ((int) $row->attempts >= 3) {
            return response('Zbyt wiele prób.', 429);
        }

        DB::table('otp_codes')->where('id', $row->id)->update([
            'attempts' => DB::raw('attempts + 1'),
            'updated_at' => now(),
        ]);

        if (!Hash::check($otp, $row->code_hash)) {
            return response('Błędny kod.', 422);
        }

        try {
            DB::transaction(function () use ($firm, $phone, $row) {

                $client = Client::where('phone', $phone)->firstOrFail();

                $pass = DB::table('user_passes')
                    ->where('client_id', $client->id)
                    ->where('firm_id', $firm->id)
                    ->where('status', 'active')
                    ->where('remaining_entries', '>', 0)
                    ->lockForUpdate()
                    ->first();

                if (!$pass) {
                    throw new \Exception('Brak aktywnego karnetu lub brak wejść.');
                }

                $newRemaining = $pass->remaining_entries - 1;

                DB::table('user_passes')
                    ->where('id', $pass->id)
                    ->update([
                        'remaining_entries' => $newRemaining,
                        'status' => $newRemaining === 0 ? 'finished' : 'active',
                        'finished_at' => $newRemaining === 0 ? now() : null,
                        'updated_at' => now(),
                    ]);

                DB::table('pass_usages')->insert([
                    'user_pass_id' => $pass->id,
                    'client_id' => $client->id,
                    'firm_id' => $firm->id,
                    'used_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('otp_codes')
                    ->where('id', $row->id)
                    ->update([
                        'used_at' => now(),
                        'updated_at' => now(),
                    ]);

                $client->touchActivity();
            });

        } catch (\Exception $e) {
            return response($e->getMessage(), 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Wejście odjęte poprawnie.',
        ]);
    }
}
