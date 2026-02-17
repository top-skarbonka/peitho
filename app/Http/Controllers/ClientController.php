<?php

namespace App\Http\Controllers;

use App\Models\LoyaltyCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
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

        return view('client.dashboard', [
            'client'  => $client,
            'grouped' => $grouped,
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

        try {
            if (Schema::hasTable('consent_logs')) {

                $cols = Schema::getColumnListing('consent_logs');

                $payload = [
                    'loyalty_card_id' => $card->id,
                    'client_id'       => $client->id,
                    'firm_id'         => $card->firm_id,
                    'old_value'       => $oldValue,
                    'new_value'       => $newValue,
                    'ip_address'      => $request->ip(),
                    'user_agent'      => substr((string) $request->userAgent(), 0, 500),
                    'source'          => 'client_wallet',
                    'created_at'      => $now,
                    'updated_at'      => $now,
                ];

                $filtered = array_intersect_key($payload, array_flip($cols));

                if (! empty($filtered)) {
                    DB::table('consent_logs')->insert($filtered);
                } else {
                    Log::warning('consent_logs table has no expected columns; consent not logged there', [
                        'card_id'   => $card->id,
                        'client_id' => $client->id,
                        'firm_id'   => $card->firm_id,
                    ]);
                }
            }
        } catch (\Throwable $e) {
            Log::error('Failed to insert consent log', [
                'error'     => $e->getMessage(),
                'card_id'   => $card->id,
                'client_id' => $client->id,
                'firm_id'   => $card->firm_id,
            ]);
        }

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

        // 🔥 JEDYNA ZMIANA: DODANY 'workshop'
        $allowed = [
            'classic',
            'florist',
            'hair_salon',
            'pizzeria',
            'kebab',
            'cafe',
            'workshop', // <-- NOWY LAYOUT
        ];

        if (! in_array($template, $allowed, true)) {
            $template = 'classic';
        }

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
}
