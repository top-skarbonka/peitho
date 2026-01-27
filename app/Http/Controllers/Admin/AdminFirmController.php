<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Firm;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AdminFirmController extends Controller
{
    public function create()
    {
        return view('admin.firms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email',
            'city'        => 'required|string|max:255',
            'address'     => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'nip'         => 'nullable|string|max:20',
            'phone'       => 'nullable|string|max:20',

            // 🎨 karta
            'card_template' => 'required|string',

            // 🔗 linki
            'facebook_url'  => 'nullable|url',
            'instagram_url' => 'nullable|url',

            // ⬇️ KLUCZOWA ZMIANA
            // Google opinie – długie URL-e → string
            'google_url'    => 'nullable|string|max:2000',
        ]);

        $password = Str::random(10);
        $slug = Str::slug($request->name) . '-' . rand(1000, 9999);

        $firm = Firm::create([
            'firm_id'     => $slug,
            'slug'        => $slug,
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => Hash::make($password),
            'city'        => $request->city,
            'address'     => $request->address,
            'postal_code' => $request->postal_code,
            'nip'         => $request->nip,
            'phone'       => $request->phone,
            'program_id'  => 1,

            'card_template' => $request->card_template,

            // 🔗 linki
            'facebook_url'  => $request->facebook_url,
            'instagram_url' => $request->instagram_url,
            'google_url'    => $request->google_url,
        ]);

        return redirect()
            ->route('admin.firms.create')
            ->with('success', [
                'firm_id'  => $firm->firm_id,
                'email'    => $firm->email,
                'password' => $password,
                'link'     => url('/join/' . $firm->slug),
            ]);
    }
}
