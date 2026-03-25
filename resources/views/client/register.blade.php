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

        {{-- KOMUNIKATY BŁĘDÓW --}}
        @if ($errors->any())
            <div style="
                background:#fff4f4;
                border:1px solid #ffb3b3;
                color:#8a0000;
                padding:14px;
                border-radius:10px;
                margin-bottom:18px;
                font-size:14px;
            ">
                <strong style="display:block; margin-bottom:6px;">
                    ⚠️ Coś poszło nie tak
                </strong>

                <ul style="margin:0; padding-left:18px;">
                    @foreach ($errors->all() as $error)

                        @if ($error === 'validation.min.string')
                            <li style="margin-bottom:4px;">
                                Hasło musi mieć minimum 4 znaki.
                            </li>

                        @elseif (str_contains($error, 'Nieprawidłowe hasło'))
                            <li style="margin-bottom:4px;">
                                Masz już portfel. Wpisz swoje hasło, które ustawiłeś wcześniej.
                            </li>

                        @else
                            <li style="margin-bottom:4px;">
                                {{ $error }}
                            </li>
                        @endif

                    @endforeach
                </ul>

                <div style="margin-top:8px; font-size:13px; color:#555;">
                    Popraw zaznaczone pola i spróbuj ponownie.
                </div>
            </div>
        @endif

<form method="POST"
      action="{{ route('client.register.by_firm.submit', ['slug' => $firm->slug]) }}">
            @csrf

            {{-- IMIĘ --}}
            <label style="font-weight:600;">Imię (opcjonalnie)</label>
            <input type="text" name="name" value="{{ old('name') }}"
                   placeholder="Np. Anna"
                   style="width:100%;padding:12px;border-radius:10px;border:1px solid #ddd;margin-bottom:14px;">

            {{-- TELEFON --}}
            <label style="font-weight:600;">
                Numer telefonu <span style="color:red">*</span>
            </label>
            <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required
                   placeholder="Np. 500600700"
                   style="width:100%;padding:14px;border-radius:12px;border:2px solid #6a5af9;margin-bottom:6px;font-size:16px;">

            <div id="phoneError" style="display:none;color:red;font-size:13px;margin-bottom:14px;">
                📱 Najpierw wpisz swój numer telefonu
            </div>

            {{-- KOD POCZTOWY --}}
            <label style="font-weight:600;">Kod pocztowy (opcjonalnie)</label>
            <input type="text" name="postal_code" value="{{ old('postal_code') }}"
                   placeholder="00-000"
                   style="width:100%;padding:12px;border-radius:10px;border:1px solid #ddd;margin-bottom:14px;">

            {{-- HASŁO --}}
            <label style="font-weight:600;">Hasło</label>
            <input type="password" name="password" required
                   placeholder="Minimum 4 znaki"
                   style="width:100%;padding:12px;border-radius:10px;border:1px solid #ddd;margin-bottom:6px;">

            <div style="text-align:right; margin-bottom:14px;">
                <a href="#" onclick="resetPassword(); return false;" style="font-size:13px;color:#6a5af9;text-decoration:underline;">
                    Nie pamiętasz hasła?
                </a>
            </div>

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
                    <input type="checkbox" name="sms_marketing_consent" value="1">
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
            <label style="display:flex;gap:10px;font-size:14px;margin-bottom:18px;align-items:flex-start;">
                <input type="checkbox" required>
                <span>
                    Akceptuję
                    <a href="/docs/regulamin.pdf" target="_blank" style="color:#6a5af9;font-weight:700;text-decoration:underline;">
                        regulamin
                    </a>
                    oraz
                    <a href="/docs/polityka%20prywatnosci.pdf" target="_blank" style="color:#6a5af9;font-weight:700;text-decoration:underline;">
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

        <p style="text-align:center;font-size:13px;color:#888;margin-top:16px;">
            Dane są bezpieczne. Możesz zrezygnować w każdej chwili.
        </p>

    </div>
</div>

<script>
function resetPassword() {
    const phoneInput = document.getElementById('phone');
    const error = document.getElementById('phoneError');

    if (!phoneInput.value) {
        phoneInput.style.border = '2px solid red';
        error.style.display = 'block';
        phoneInput.focus();
        return;
    }

    alert('Wyślemy link do ustawienia hasła 📩');
}

document.getElementById('phone').addEventListener('input', function () {
    this.style.border = '2px solid #6a5af9';
    document.getElementById('phoneError').style.display = 'none';
});
</script>

@endsection
