@extends('layouts.public')

@section('content')
<div style="max-width:720px;margin:40px auto;padding:30px;background:#fff;border-radius:16px;box-shadow:0 20px 60px rgba(0,0,0,.15)">

    <h2 style="margin-bottom:6px;">➕ Rejestracja nowej firmy</h2>
    <p style="color:#666;margin-bottom:24px;">Panel administratora</p>

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

    <form method="POST" action="{{ route('admin.firms.store') }}">
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

        <h4>🎨 Wygląd karty lojalnościowej</h4>

    <label class="block text-sm font-medium mb-1">Szablon karty</label>

    <select name="card_template"
            class="w-full rounded-lg border border-slate-300 px-3 py-2">
        <option value="gold" {{ old('card_template','gold')=='gold' ? 'selected' : '' }}>Gold (premium)</option>
        <option value="elegant" {{ old('card_template')=='elegant' ? 'selected' : '' }}>Elegant</option>
        <option value="modern" {{ old('card_template')=='modern' ? 'selected' : '' }}>Modern</option>
        <option value="classic" {{ old('card_template')=='classic' ? 'selected' : '' }}>Classic</option>        </select>

        <hr style="margin:24px 0">

        <h4>🔗 Linki social / opinie</h4>

        <input name="facebook_url" placeholder="Facebook (URL)" style="width:100%;padding:12px;margin-bottom:10px">
        <input name="instagram_url" placeholder="Instagram (URL)" style="width:100%;padding:12px;margin-bottom:10px">
        <input name="google_review_url" placeholder="Google – opinie (URL)" style="width:100%;padding:12px;margin-bottom:20px">
<div class="form-group">
    <label for="google_url">Strona WWW firmy</label>
    <input
        type="url"
        name="google_url"
        id="google_url"
        class="form-control"
        placeholder="https://www.twojafirma.pl"
        value="{{ old('google_url') }}"
    >
    <small class="text-muted">
        Adres strony WWW – pojawi się jako przycisk 🌐 WWW na karcie klienta
    </small>
</div>
        <button type="submit" style="
            width:100%;
            padding:14px;
            border:none;
            border-radius:14px;
            font-size:16px;
            font-weight:700;
            color:#fff;
            background:linear-gradient(135deg,#6a5af9,#ff5fa2);
            cursor:pointer;
        ">
            🚀 Utwórz firmę
        </button>

    </form>

</div>
@endsection
