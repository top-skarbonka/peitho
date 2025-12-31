<?php

namespace App\Http\Controllers;

use App\Models\Firm;
use Illuminate\Http\Request;

class PublicCardRegisterController extends Controller
{
    /**
     * Formularz rejestracji karty stałego klienta (publiczny)
     * URL: /register/card/{hash}
     */
    public function show(string $hash)
    {
        $firm = Firm::where('public_hash', $hash)->firstOrFail();

        return view('public.card-register', [
            'firm' => $firm,
        ]);
    }
}
