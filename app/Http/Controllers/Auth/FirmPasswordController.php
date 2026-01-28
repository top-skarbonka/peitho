<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FirmPasswordController extends Controller
{
    public function show()
    {
        return view('company.change-password');
    }

public function update(Request $request)
{
    $request->validate(
        [
            'password' => 'required|min:8|confirmed',
        ],
        [
            'password.required' => 'Hasło jest wymagane.',
            'password.min' => 'Hasło musi mieć minimum 8 znaków.',
            'password.confirmed' => 'Hasła nie są takie same.',
        ]
    );

    $firm = Auth::guard('company')->user();

    $firm->password = Hash::make($request->password);
    $firm->password_changed_at = now();
    $firm->save();

    return redirect()
        ->route('company.dashboard')
        ->with('success', 'Hasło zostało zmienione');
}}
