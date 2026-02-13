<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Firm;
use App\Models\LoyaltyCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class PublicClientController extends Controller
{
    public function showRegisterFormByFirm(string $slug)
    {
        $firm = Firm::where('slug', $slug)->firstOrFail();

        return view('client.register', [
            'firm' => $firm,
        ]);
    }

    public function registerByFirm(Request $request, string $slug)
    {
        $firm = Firm::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'phone'                 => 'required|min:6',
            'password'              => 'required|min:4',
            'name'                  => 'nullable|string|max:255',
            'postal_code'           => 'nullable|string|max:20',
            'sms_marketing_consent' => 'nullable|in:1',
        ]);

        $now = Carbon::now();

        /*
        |--------------------------------------------------------------------------
        | 🔍 1️⃣ SPRAWDZAMY CZY KLIENT JUŻ ISTNIEJE (PORTFEL GLOBALNY)
        |--------------------------------------------------------------------------
        */

        $client = Client::where('phone', $validated['phone'])->first();

        if (! $client) {
            // 👤 NOWY KLIENT
            $client = Client::create([
                'firm_id'                  => $firm->id,
                'program_id'               => $firm->program_id,
                'name'                     => $validated['name'] ?? null,
                'phone'                    => $validated['phone'],
                'postal_code'              => $validated['postal_code'] ?? null,
                'password'                 => Hash::make($validated['password']),
                'sms_marketing_consent'    => isset($validated['sms_marketing_consent']),
                'sms_marketing_consent_at' => isset($validated['sms_marketing_consent']) ? $now : null,
                'terms_accepted_at'        => $now,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 🔒 2️⃣ BLOKADA DUPLIKATU KARTY DLA TEJ SAMEJ FIRMY
        |--------------------------------------------------------------------------
        */

        $existingCard = LoyaltyCard::where('client_id', $client->id)
            ->where('firm_id', $firm->id)
            ->first();

        if ($existingCard) {
            return back()
                ->withErrors([
                    'phone' => 'Masz już kartę w tej firmie.',
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | 💳 3️⃣ TWORZYMY NOWĄ KARTĘ
        |--------------------------------------------------------------------------
        */

        $consent = isset($validated['sms_marketing_consent']);

        $card = LoyaltyCard::create([
            'client_id'            => $client->id,
            'firm_id'              => $firm->id,
            'program_id'           => $firm->program_id,
            'stamps'               => $firm->start_stamps ?? 0,
            'marketing_consent'    => $consent,
            'marketing_consent_at' => $consent ? $now : null,
        ]);

        /*
        |--------------------------------------------------------------------------
        | 🛡 4️⃣ LOG RODO – DECYZJA PRZY REJESTRACJI
        |--------------------------------------------------------------------------
        */

        DB::table('consent_logs')->insert([
            'loyalty_card_id' => $card->id,
            'client_id'       => $client->id,
            'firm_id'         => $firm->id,
            'old_value'       => null,
            'new_value'       => $consent ? 1 : 0,
            'ip_address'      => $request->ip(),
            'user_agent'      => substr((string) $request->userAgent(), 0, 500),
            'source'          => 'client_register',
            'created_at'      => $now,
            'updated_at'      => $now,
        ]);

        auth('client')->login($client);

        session()->flash('first_time_wallet', true);

        return redirect()->route('client.dashboard');
    }

    public function loyaltyCard()
    {
        $client = auth('client')->user();

        $firm = Firm::findOrFail($client->firm_id);

        $card = LoyaltyCard::where('client_id', $client->id)
            ->where('firm_id', $firm->id)
            ->firstOrFail();

        $template = $firm->card_template ?? 'classic';

        return view('client.cards.' . $template, [
            'client' => $client,
            'firm'   => $firm,
            'card'   => $card,
        ]);
    }
}
