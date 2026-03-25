@extends('layouts.public')

@section('content')
<div style="max-width:760px;margin:40px auto;padding:30px;background:#fff;border-radius:16px;box-shadow:0 20px 60px rgba(0,0,0,.15)">

    <h2 style="margin-bottom:6px;">➕ Panel administratora</h2>
    <p style="color:#666;margin-bottom:24px;">Rejestracja firm i zgodność z RODO</p>

    <div style="display:flex;gap:10px;margin-bottom:24px;">
        <button type="button" onclick="showTab('firm')" id="tab-btn-firm"
                style="flex:1;padding:12px;border-radius:12px;border:2px solid #6a5af9;background:#6a5af9;color:#fff;font-weight:700;">
            🏢 Rejestracja firmy
        </button>

        <button type="button" onclick="showTab('consents')" id="tab-btn-consents"
                style="flex:1;padding:12px;border-radius:12px;border:2px solid #ddd;background:#fff;color:#333;font-weight:700;">
            🧩 Eksport zgód (UODO)
        </button>
    </div>

    @if(session('success'))
        <div style="background:#e7fff1;border:1px solid #86efac;padding:14px;border-radius:10px;margin-bottom:20px;">
            <strong>Firma utworzona</strong><br><br>
            <b>ID firmy:</b> {{ session('success.firm_id') }}<br>
            <b>Email:</b> {{ session('success.email') }}<br>
            <b>Hasło:</b> {{ session('success.password') }}
        </div>
    @endif

    @if($errors->any())
        <div style="background:#ffecec;border:1px solid #ffb3b3;padding:12px;border-radius:10px;margin-bottom:20px;">
            {{ $errors->first() }}
        </div>
    @endif

    <div id="tab-firm">

        <form method="POST" action="{{ route('admin.firms.store') }}" enctype="multipart/form-data">
            @csrf

            <h4>🏢 Dane firmy</h4>

            <input name="name" placeholder="Nazwa firmy" required style="width:100%;padding:12px;margin-bottom:10px">
            <input name="email" placeholder="Email" required style="width:100%;padding:12px;margin-bottom:10px">
            <input name="phone" placeholder="Telefon" style="width:100%;padding:12px;margin-bottom:10px">

            <input name="city" placeholder="Miasto" required style="width:100%;padding:12px;margin-bottom:10px">
            <input name="address" placeholder="Adres" required style="width:100%;padding:12px;margin-bottom:10px">
            <input name="postal_code" placeholder="Kod pocztowy" required style="width:100%;padding:12px;margin-bottom:20px">

            <hr style="margin:24px 0">

            <h4>🧠 Typ programu</h4>

            <select name="program_type" required style="width:100%;padding:12px;margin-bottom:20px">
                <option value="points">Program punktowy ⭐</option>
                <option value="cards">Wirtualna karta (naklejki) 💳</option>
                <option value="passes">Karnety (wejścia) 🎫</option>
            </select>

            <hr style="margin:24px 0">

            <h4>🖼 Logo firmy</h4>
            <input type="file" name="logo" accept="image/*" style="width:100%;padding:12px;margin-bottom:20px">

            <hr style="margin:24px 0">

            <h4>🎨 Wygląd karty lojalnościowej</h4>

            <select name="card_template" style="width:100%;padding:12px;margin-bottom:20px">
                <option value="florist">Kwiaciarnia 🌸</option>
                <option value="hair_salon">Salon fryzjerski ✂️</option>
                <option value="pizzeria">Pizzeria 🍕</option>
                <option value="kebab">Kebab 🌯</option>
                <option value="cafe">Kawiarnia ☕</option>
                <option value="workshop">Warsztat ⚒️</option>
            </select>

            <button type="submit"
                    style="width:100%;padding:14px;border:none;border-radius:14px;font-size:16px;font-weight:700;color:#fff;background:linear-gradient(135deg,#6a5af9,#ff5fa2);">
                🚀 Utwórz firmę
            </button>
        </form>
    </div>

    <div id="tab-consents" style="display:none;">
        <h4>🧩 Eksport zgód marketingowych (RODO / UODO)</h4>
    </div>

</div>

<script>
function showTab(tab){
    document.getElementById('tab-firm').style.display = tab === 'firm' ? 'block' : 'none';
    document.getElementById('tab-consents').style.display = tab === 'consents' ? 'block' : 'none';
}
</script>
@endsection
