@extends('layouts.public')

@section('content')
<div style="max-width:520px;margin:40px auto;padding:24px;background:#fff;border-radius:16px;box-shadow:0 20px 60px rgba(0,0,0,.12);">
    <h2 style="margin:0 0 6px 0;">🔐 Ustaw hasło do portfela</h2>
    <div style="color:#666;font-size:14px;margin-bottom:16px;">
        Numer (login): <strong>{{ $phone }}</strong>
    </div>

    @if (session('error'))
        <div style="background:#fee2e2;color:#991b1b;padding:10px 12px;border-radius:12px;margin-bottom:12px;">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="background:#fff7ed;color:#9a3412;padding:10px 12px;border-radius:12px;margin-bottom:12px;">
            @foreach($errors->all() as $e)
                <div>{{ $e }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('client.set_password.store', $token) }}">
        @csrf

        <div style="margin-bottom:12px;">
            <label style="display:block;font-weight:700;margin-bottom:6px;">Nowe hasło</label>
            <input type="password" name="password" required
                   style="width:100%;padding:12px 14px;border-radius:12px;border:1px solid #e5e7eb;">
        </div>

        <div style="margin-bottom:16px;">
            <label style="display:block;font-weight:700;margin-bottom:6px;">Powtórz hasło</label>
            <input type="password" name="password_confirmation" required
                   style="width:100%;padding:12px 14px;border-radius:12px;border:1px solid #e5e7eb;">
        </div>

        <button type="submit"
                style="width:100%;padding:12px 14px;border-radius:12px;border:none;cursor:pointer;
                       background:linear-gradient(135deg,#6a5af9,#ff5fa2);color:#fff;font-weight:800;">
            Zapisz hasło
        </button>
    </form>

    <div style="margin-top:14px;color:#666;font-size:12px;">
        Po ustawieniu hasła zalogujesz się numerem telefonu i hasłem w portfelu klienta.
    </div>
</div>
@endsection
