<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\LoyaltyCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Carbon;

class ClientController extends Controller
{
    public function dashboard()
    {
        $client = Auth::guard('client')->user();

        if (! $client) {
            return redirect()->route('client.login');
        }

        $cards = LoyaltyCard::with(['firm', 'stamps'])
            ->where('client_id', $client->id)
            ->get();

        $grouped = $cards
            ->groupBy(function ($card) {
                return $card->firm->card_template ?? 'classic';
            })
            ->map(function ($cards) {
                return $cards->map(function ($card) {
                    $max = (int) ($card->firm->stamps_required ?? 10);
                    if ($max < 1) {
                        $max = 10;
                    }

                    $current = min($card->stamps->count(), $max);

                    return [
                        'card'        => $card,
                        'current'     => $current,
                        'max'         => $max,
                        'rewardReady' => $current >= $max,
                    ];
                });
            });

        // 🔥 NOWE: pobieranie karnetów
        $passes = DB::table('user_passes as up')
            ->join('company_pass_types as pt', 'pt.id', '=', 'up.pass_type_id')
            ->join('firms as f', 'f.id', '=', 'up.firm_id')
            ->where('up.client_id', $client->id)
            ->select([
                'up.id',
                'up.total_entries',
                'up.remaining_entries',
                'up.status',
                'up.activated_at',
                'up.finished_at',
                'pt.name as pass_name',
                'f.name as firm_name',
            ])
            ->orderByDesc('up.id')
            ->get();

        return view('client.dashboard', [
            'client'  => $client,
            'grouped' => $grouped,
            'passes'  => $passes, // 🔥 przekazujemy do widoku
        ]);
    }

    public function consents()
    {
        $client = Auth::guard('client')->user();

        if (! $client) {
            return redirect()->route('client.login');
        }

        $cards = LoyaltyCard::with('firm')
            ->where('client_id', $client->id)
            ->get();

        return view('client.consents', [
            'cards' => $cards,
        ]);
    }

    public function updateConsent(Request $request, LoyaltyCard $card)
    {
        $client = Auth::guard('client')->user();

        if (! $client || $card->client_id !== $client->id) {
            abort(403);
        }

        $request->validate([
            'marketing_consent' => 'required',
        ]);

        $oldValue = (int) ((bool) $card->marketing_consent);
        $newValue = (int) ($request->boolean('marketing_consent'));

        if ($oldValue === $newValue) {
            return response()->json([
                'success' => true,
                'marketing_consent' => (bool) $newValue,
            ]);
        }

        $now = Carbon::now();

        $card->marketing_consent = $newValue;
        $card->marketing_consent_at = $newValue ? $now : null;
        $card->marketing_consent_revoked_at = $newValue ? null : $now;
        $card->save();

        return response()->json([
            'success' => true,
            'marketing_consent' => (bool) $newValue,
        ]);
    }

    public function showCard(LoyaltyCard $card)
    {
        $client = Auth::guard('client')->user();

        if (! $client || $card->client_id !== $client->id) {
            abort(403);
        }

        $maxStamps = (int) ($card->firm->stamps_required ?? 10);
        if ($maxStamps < 1) {
            $maxStamps = 10;
        }

        $current = min($card->stamps->count(), $maxStamps);

        $displayCode = str_pad((string) $card->id, 8, '0', STR_PAD_LEFT);
        $qrPayload = $card->qr_code ?: ('CARD:' . $card->id);

        $qr = QrCode::format('svg')
            ->size(170)
            ->margin(0)
            ->generate($qrPayload);

        $template = $card->firm->card_template ?? 'classic';

        return view("client.cards.$template", [
            'card'        => $card,
            'client'      => $client,
            'firm'        => $card->firm,
            'maxStamps'   => $maxStamps,
            'current'     => $current,
            'displayCode' => $displayCode,
            'qr'          => $qr,
        ]);
    }

    public function loyaltyCard()
    {
        $client = Auth::guard('client')->user();

        if (! $client) {
            return redirect()->route('client.login');
        }

        $card = LoyaltyCard::with(['firm', 'stamps'])
            ->where('client_id', $client->id)
            ->latest()
            ->first();

        if (! $card) {
            abort(404, 'Brak przypisanej karty lojalnościowej');
        }

        return $this->showCard($card);
    }

    /*
    |--------------------------------------------------------------------------
    | PORTFEL — USTAWIENIE HASŁA PRZEZ LINK Z SMS (TOKEN)
    |--------------------------------------------------------------------------
    */

    public function activateForm(string $token)
    {
        $client = Client::where('activation_token', $token)->first();

        if (! $client) {
            abort(404, 'Nieprawidłowy token.');
        }

        if ($client->activation_token_expires_at && now()->greaterThan($client->activation_token_expires_at)) {
            abort(410, 'Token wygasł.');
        }

        return view('client.activate', [
            'token' => $token,
            'phone' => $client->phone,
        ]);
    }

    public function activateSubmit(Request $request, string $token)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $client = Client::where('activation_token', $token)->first();

        if (! $client) {
            abort(404, 'Nieprawidłowy token.');
        }

        if ($client->activation_token_expires_at && now()->greaterThan($client->activation_token_expires_at)) {
            abort(410, 'Token wygasł.');
        }

        DB::transaction(function () use ($client, $request) {
            $client->password = Hash::make((string) $request->input('password'));
            $client->password_set = 1;
            $client->activation_token = null;
            $client->activation_token_expires_at = null;
            $client->save();
        });

        // logujemy klienta automatycznie po ustawieniu hasła
        Auth::guard('client')->login($client);

        return redirect()
            ->route('client.dashboard')
            ->with('success', 'Hasło ustawione ✅ Możesz się teraz logować numerem telefonu.');
    }
}
