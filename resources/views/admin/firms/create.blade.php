@extends('layouts.app')

@section('content')
<div style="
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    background:#f4f6fb;
">
    <div style="
        width:420px;
        background:#fff;
        border-radius:16px;
        padding:32px;
        box-shadow:0 20px 40px rgba(0,0,0,.12);
    ">

        <h2 style="text-align:center; margin-bottom:8px;">
            🏢 Rejestracja firmy
        </h2>

        <p style="text-align:center; color:#666; margin-bottom:24px;">
            Formularz wewnętrzny (panel admina)
        </p>

        {{-- ✅ KOMUNIKAT PO UTWORZENIU FIRMY --}}
        @if(session('success'))
            <div style="
                background:#e6fffa;
                border:1px solid #38b2ac;
                color:#065f46;
                padding:16px;
                border-radius:12px;
                margin-bottom:20px;
                font-size:14px;
            ">
                <strong>✅ Firma została utworzona</strong><br><br>

                <div><b>ID firmy:</b> {{ session('success.firm_id') }}</div>
                <div><b>Email:</b> {{ session('success.email') ?? '—' }}</div>
                <div><b>Hasło:</b> {{ session('success.password') }}</div>

                <hr style="margin:12px 0">

                <small>
                    Logowanie firmy:<br>
                    <code>{{ url('/company/login') }}</code>
                </small>
            </div>
        @endif

        {{-- ❌ BŁĘDY WALIDACJI --}}
        @if ($errors->any())
            <div style="
                background:#fff5f5;
                border:1px solid #e53e3e;
                color:#742a2a;
                padding:12px;
                border-radius:12px;
                margin-bottom:16px;
                font-size:14px;
            ">
                <ul style="margin:0; padding-left:18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.firms.store') }}">
            @csrf

            <input class="input" name="name" placeholder="Nazwa firmy" required>
            <input class="input" name="city" placeholder="Miasto" required>
            <input class="input" name="address" placeholder="Ulica i numer" required>
            <input class="input" name="postal_code" placeholder="Kod pocztowy" required>
            <input class="input" name="nip" placeholder="NIP">
            <input class="input" name="email" placeholder="Adres e-mail" required>
            <input class="input" name="phone" placeholder="Numer telefonu">

            <button type="submit" style="
                width:100%;
                margin-top:20px;
                padding:14px;
                border-radius:12px;
                border:none;
                background:#5b4df5;
                color:#fff;
                font-size:16px;
                font-weight:600;
                cursor:pointer;
            ">
                💾 Zarejestruj firmę
            </button>
        </form>

    </div>
</div>

<style>
.input{
    width:100%;
    padding:12px 14px;
    margin-bottom:12px;
    border-radius:12px;
    border:1px solid #ddd;
    font-size:14px;
}
.input:focus{
    outline:none;
    border-color:#5b4df5;
    box-shadow:0 0 0 2px rgba(91,77,245,.15);
}
</style>
@endsection
