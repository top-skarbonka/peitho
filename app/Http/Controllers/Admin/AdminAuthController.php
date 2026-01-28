<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function show()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required'
        ]);

        if ($request->password !== config('app.admin_password')) {
            return back()->withErrors([
                'password' => 'Nieprawidłowe hasło admina'
            ]);
        }

        session(['admin_ok' => true]);

return redirect()->route('admin.dashboard');    }

    public function logout()
    {
        session()->forget('admin_ok');
        return redirect()->route('admin.login');
    }
}
