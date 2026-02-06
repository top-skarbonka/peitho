@extends('layouts.public')

@section('content')
<div style="max-width:760px;margin:40px auto;padding:30px;background:#fff;border-radius:16px;box-shadow:0 20px 60px rgba(0,0,0,.15)">

    <h2 style="margin-bottom:6px;">➕ Panel administratora</h2>
    <p style="color:#666;margin-bottom:24px;">Rejestracja firm i zgodność z RODO</p>

    {{-- TABS --}}
    <div style="display:flex;gap:10px;margin-bottom:24px;">
        <button type="button"
                onclick="showTab('firm')"
                id="tab-btn-firm"
                style="flex:1;padding:12px;border-radius:12px;border:2px solid #6a5af9;background:#6a5af9;color:#fff;font-weight:700;">
            🏢 Rejestracja firmy
        </button>

        <button type="button"
                onclick="showTab('consents')"
                id="tab-btn-consents"
                style="flex:1;padding:12px;border-radius:12px;border:2px solid #ddd;background:#fff;color:#333;font-weight:700;">
            🧩 Eksport zgód (UODO)
        </button>
    </div>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div style="background:#e7fff1;border:1px solid #86efac;padding:14px;border-radius:10px;margin-bottom:20px;">
            <strong>Firma utworzona</strong><br><br>
            <b>ID firmy:</b> {{ session('success.firm_id') }}<br>
            <b>Email:</b> {{ session('success.email') }}<br>
            <b>Hasło:</b> {{ session('success.password') }}
        </div>
    @endif

    {{-- ERRORS --}}
    @if($errors->any())
        <div style="background:#ffecec;border:1px solid #ffb3b3;padding:12px;border-radius:10px;margin-bottom:20px;">
            {{ $errors->first() }}
        </div>
    @endif

    {{-- TAB: FIRMA --}}
    <div id="tab-firm">

        {{-- ⬇️ WAŻNE: multipart --}}
        <form method="POST"
              action="{{ route('admin.firms.store') }}"
              enctype="multipart/form-data">
            @csrf

            <h4>🏢 Dane firmy</h4>

            <input name="name" placeholder="Nazwa firmy" required style="width:100%;padding:12px;margin-bottom:10px">
            <input name="email" placeholder="Email" required style="width:100%;padding:12px;margin-bottom:10px">
            <input name="phone" placeholder="Telefon" style="width:100%;padding:12px;margin-bottom:10px">

            <input name="city" placeholder="Miasto" required style="width:100%;padding:12px;margin-bottom:10px">
            <input name="address" placeholder="Adres" required style="width:100%;padding:12px;margin-bottom:10px">
            <input name="postal_code" placeholder="Kod pocztowy" required style="width:100%;padding:12px;margin-bottom:10px">
            <input name="nip" placeholder="NIP (opcjonalnie)" style="width:100%;padding:12px;margin-bottom:20px">

            <hr style="margin:24px 0">

            <h4>🖼 Logo firmy</h4>
            <input type="file"
                   name="logo"
                   accept="image/*"
                   style="width:100%;padding:12px;margin-bottom:20px">

            <hr style="margin:24px 0">

            <h4>🎨 Wygląd karty lojalnościowej</h4>

<select name="card_template" style="width:100%;padding:12px;margin-bottom:20px">
    <option value="classic">Classic</option>
    <option value="modern">Modern</option>
    <option value="elegant">Elegant</option>
    <option value="gold">Gold</option>
    <option value="florist">Kwiaciarnia 🌸</option>
    <option value="hair_salon">Salon fryzjerski ✂️</option>
</select>
            <hr style="margin:24px 0">

            <h4>🔗 Linki</h4>

            <input name="facebook_url" placeholder="Facebook (URL)" style="width:100%;padding:12px;margin-bottom:10px">
            <input name="instagram_url" placeholder="Instagram (URL)" style="width:100%;padding:12px;margin-bottom:10px">
            <input name="google_url" placeholder="Google / opinie / strona" style="width:100%;padding:12px;margin-bottom:20px">

            <button type="submit"
                    style="width:100%;padding:14px;border:none;border-radius:14px;font-size:16px;font-weight:700;color:#fff;background:linear-gradient(135deg,#6a5af9,#ff5fa2);">
                🚀 Utwórz firmę
            </button>
        </form>
    </div>

    {{-- TAB: CONSENTS --}}
    <div id="tab-consents" style="display:none;">
        <h4>🧩 Eksport zgód marketingowych (RODO / UODO)</h4>
        <p style="color:#666">Ten moduł już działa ✔</p>
    </div>

</div>

<script>
function showTab(tab){
    document.getElementById('tab-firm').style.display = tab === 'firm' ? 'block' : 'none';
    document.getElementById('tab-consents').style.display = tab === 'consents' ? 'block' : 'none';
}
</script>
@endsection
