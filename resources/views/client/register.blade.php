@extends('layouts.public')

@section('content')
<div style="
    min-height: 100vh;
    background: linear-gradient(135deg, #6a5af9, #8f5cff, #ff7ab6);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
">

    <div style="
        background: #ffffff;
        width: 100%;
        max-width: 420px;
        border-radius: 16px;
        padding: 28px;
        box-shadow: 0 20px 50px rgba(0,0,0,.2);
    ">

        <h2 style="margin-bottom: 4px;">🎁 Karta Stałego Klienta</h2>
        <p style="margin-top: 0; color:#666;">
            {{ $firm->name }}
        </p>

        {{-- KOMUNIKATY --}}
        @if ($errors->any())
            <div style="
                background:#ffecec;
                border:1px solid #ffb3b3;
                color:#a40000;
                padding:10px;
                border-radius:8px;
                margin-bottom:16px;
                font-size:14px;
            ">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST"
              action="{{ route('client.register.by_firm.submit', ['firm_id' => $firm->id]) }}">
            @csrf

            {{-- IMIĘ --}}
            <label style="font-weight:600;">Imię (opcjonalnie)</label>
            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                placeholder="Np. Anna"
                style="
                    width:100%;
                    padding:12px;
                    border-radius:10px;
                    border:1px solid #ddd;
                    margin-bottom:14px;
                "
            >

            {{-- TELEFON --}}
            <label style="font-weight:600;">
                Numer telefonu <span style="color:red">*</span>
            </label>
            <input
                type="text"
                name="phone"
                value="{{ old('phone') }}"
                placeholder="Np. 500600700"
                required
                style="
                    width:100%;
                    padding:14px;
                    border-radius:12px;
                    border:2px solid #6a5af9;
                    margin-bottom:14px;
                    font-size:16px;
                "
            >

            {{-- KOD POCZTOWY --}}
            <label style="font-weight:600;">Kod pocztowy (opcjonalnie)</label>
            <input
                type="text"
                name="postal_code"
                value="{{ old('postal_code') }}"
                placeholder="00-000"
                style="
                    width:100%;
                    padding:12px;
                    border-radius:10px;
                    border:1px solid #ddd;
                    margin-bottom:14px;
                "
            >

            {{-- HASŁO --}}
            <label style="font-weight:600;">Hasło</label>
            <input
                type="password"
                name="password"
                placeholder="Minimum 4 znaki"
                required
                style="
                    width:100%;
                    padding:12px;
                    border-radius:10px;
                    border:1px solid #ddd;
                    margin-bottom:14px;
                "
            >

            {{-- ZGODA MARKETINGOWA --}}
            <div style="
                margin-top:16px;
                padding:12px;
                border:2px dashed #7c6cf3;
                border-radius:12px;
                background:#f8f7ff;
                margin-bottom:16px;
            ">
                <label style="display:flex; align-items:flex-start; gap:12px; cursor:pointer;">
                    <input
                        type="checkbox"
                        name="sms_marketing_consent"
                        value="1"
                        style="
                            width:44px;
                            height:24px;
                            appearance:none;
                            background:#ddd;
                            border-radius:20px;
                            position:relative;
                            outline:none;
                            cursor:pointer;
                            transition:.3s;
                        "
                        oninput="this.style.background=this.checked?'#6a5af9':'#ddd';this.nextElementSibling.style.transform=this.checked?'translateX(20px)':'translateX(0)'"
                    >
                    <span style="
                        position:relative;
                        left:-44px;
                        top:2px;
                        width:20px;
                        height:20px;
                        background:#fff;
                        border-radius:50%;
                        display:inline-block;
                        transition:.3s;
                        pointer-events:none;
                    "></span>

                    <div>
                        <strong>✨ Chcę otrzymywać SMS-y o promocjach i ofertach specjalnych</strong>
                        <div style="font-size:13px; color:#555; margin-top:6px; line-height:1.4;">
                            📢 Informacje o rabatach i gratisach<br>
                            📩 Maksymalnie kilka SMS-ów miesięcznie<br>
                            🌍 Od firm z Twojej okolicy
                        </div>
                    </div>
                </label>
            </div>

            {{-- REGULAMIN --}}
            <label style="
                display:flex;
                gap:10px;
                font-size:14px;
                margin-bottom:18px;
                align-items:flex-start;
            ">
                <input type="checkbox" required>
                <span>
                    Akceptuję
                    <a href="/docs/regulamin.pdf"
                       target="_blank"
                       style="color:#6a5af9; font-weight:600; text-decoration:underline;">
                        regulamin
                    </a>
                    oraz
                    <a href="/docs/polityka%20prywatnosci.pdf"
                       target="_blank"
                       style="color:#6a5af9; font-weight:600; text-decoration:underline;">
                        politykę prywatności
                    </a>
                </span>
            </label>

            <button type="submit" style="
                width:100%;
                padding:14px;
                border:none;
                border-radius:14px;
                font-size:16px;
                font-weight:700;
                color:#fff;
                cursor:pointer;
                background: linear-gradient(135deg,#6a5af9,#ff5fa2);
            ">
                🚀 Zarejestruj kartę
            </button>

        </form>

        <p style="
            text-align:center;
            font-size:13px;
            color:#888;
            margin-top:16px;
        ">
            Dane są bezpieczne. Możesz zrezygnować w każdej chwili.
        </p>

    </div>
</div>
@endsection
