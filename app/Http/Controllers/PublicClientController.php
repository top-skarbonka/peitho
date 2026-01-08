<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Firm;
use App\Models\LoyaltyCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PublicClientController extends Controller
{
    /**
     * GET /join/{slug}
     */
    public function showRegisterFormByFirm(string $slug)
    {
        $firm = Firm::where('slug', $slug)->firstOrFail();

        return view('client.register', [
            'firm' => $firm
        ]);
    }

    /**
     * POST /join/{firm_id}
     */
    public function registerByFirm(Request $request, int $firm_id)
    {
        $firm = Firm::findOrFail($firm_id);

        $request->validate([
            'phone' => 'required|min:6',
            'password' => 'required|min:4',
        ]);

        // 🔒 blokada duplikatu
        if (Client::where('phone', $request->phone)->where('firm_id', $firm->id)->exists()) {
            return back()->withErrors([
                'phone' => 'Ten numer telefonu ma już kartę w tej firmie.',
            ])->withInput();
        }

        // ✅ KLIENT
        $client = Client::create([
            'firm_id' => $firm->id,
            'program_id' => $firm->program_id,
            'name' => $request->name,
            'phone' => $request->phone,
            'postal_code' => $request->postal_code,
            'password' => Hash::make($request->password),
            'sms_marketing_consent' => $request->boolean('sms_marketing_consent'),
        ]);

        // ✅ KARTA
        LoyaltyCard::create([
            'client_id' => $client->id,
            'firm_id' => $firm->id,
            'program_id' => $firm->program_id,
            'stamps' => $firm->start_stamps ?? 0,
        ]);

        auth('client')->login($client);

        return redirect()->route('client.loyalty.card');
    }
}
