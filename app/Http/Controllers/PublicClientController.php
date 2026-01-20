<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Firm;
use App\Models\LoyaltyCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class PublicClientController extends Controller
{
    /**
     * ============================
     * GET /join/{slug}
     * ============================
     */
    public function showRegisterFormByFirm(string $slug)
    {
        $firm = Firm::where('slug', $slug)->firstOrFail();

        return view('client.register', [
            'firm' => $firm,
        ]);
    }

    /**
     * ============================
     * POST /join/{firm}
     * ============================
     */
    public function registerByFirm(Request $request, int $firm)
    {
        $firm = Firm::findOrFail($firm);

        $validated = $request->validate([
            'phone'                 => 'required|min:6',
            'password'              => 'required|min:4',
            'name'                  => 'nullable|string|max:255',
            'postal_code'           => 'nullable|string|max:20',
            'sms_marketing_consent' => 'nullable|in:1',
        ]);

        // 🔒 1 numer = 1 karta w tej firmie
        if (
            Client::where('phone', $validated['phone'])
                ->where('firm_id', $firm->id)
                ->exists()
        ) {
            return back()
                ->withErrors([
                    'phone' => 'Ten numer telefonu ma już kartę w tej firmie.',
                ])
                ->withInput();
        }

        $now = Carbon::now();

        // ✅ KLIENT (RODO KOMPLET)
        $client = Client::create([
            'firm_id'                  => $firm->id,
            'program_id'               => $firm->program_id,
            'name'                     => $validated['name'] ?? null,
            'phone'                    => $validated['phone'],
            'postal_code'              => $validated['postal_code'] ?? null,
            'password'                 => Hash::make($validated['password']),

            // ✅ ZGODY
            'sms_marketing_consent'    => isset($validated['sms_marketing_consent']),
            'sms_marketing_consent_at' => isset($validated['sms_marketing_consent']) ? $now : null,
            'terms_accepted_at'        => $now,
        ]);

        // ✅ KARTA
        LoyaltyCard::create([
            'client_id'  => $client->id,
            'firm_id'    => $firm->id,
            'program_id' => $firm->program_id,
            'stamps'     => $firm->start_stamps ?? 0,
        ]);

        auth('client')->login($client);

        return redirect()->route('client.loyalty.card');
    }

    /**
     * ============================
     * KARTA KLIENTA
     * ============================
     */
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
