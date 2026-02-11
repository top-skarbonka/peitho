@extends('layouts.public')

@section('content')
<div style="
    max-width:760px;
    margin:40px auto;
    padding:30px;
    background:#fff;
    border-radius:16px;
    box-shadow:0 20px 60px rgba(0,0,0,.15);
">

{{-- 📊 STATYSTYKI --}}
<div style="
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
    gap:16px;
    margin-bottom:30px;
">
    <div style="background:#f9fafb;padding:16px;border-radius:14px;">
        <div style="font-size:13px;color:#6b7280;">Łączne naklejki</div>
        <div style="font-size:26px;font-weight:800;">{{ $totalStamps }}</div>
    </div>

    <div style="background:#f9fafb;padding:16px;border-radius:14px;">
        <div style="font-size:13px;color:#6b7280;">Ten miesiąc</div>
        <div style="font-size:26px;font-weight:800;">{{ $monthStamps }}</div>
    </div>

    <div style="background:#f9fafb;padding:16px;border-radius:14px;">
        <div style="font-size:13px;color:#6b7280;">Karty</div>
        <div style="font-size:26px;font-weight:800;">{{ $cardsCount }}</div>
    </div>

    <div style="background:#f9fafb;padding:16px;border-radius:14px;">
        <div style="font-size:13px;color:#6b7280;">Klienci</div>
        <div style="font-size:26px;font-weight:800;">{{ $clientsCount }}</div>
    </div>
</div>

<h2>✏️ Edycja firmy</h2>

@if(session('success'))
<div style="background:#e7fff1;border:1px solid #86efac;padding:14px;border-radius:10px;margin-bottom:20px;">
    {{ session('success') }}
</div>
@endif

@if($errors->any())
<div style="background:#ffecec;border:1px solid #ffb3b3;padding:14px;border-radius:10px;margin-bottom:20px;">
    {{ $errors->first() }}
</div>
@endif

<form method="POST" action="{{ route('admin.firms.update', $firm) }}" enctype="multipart/form-data">
@csrf
@method('PUT')

{{-- DANE --}}
<h4>🏢 Dane firmy</h4>
<input name="name" value="{{ old('name',$firm->name) }}" placeholder="Nazwa firmy" required style="width:100%;padding:12px;margin-bottom:10px">
<input name="city" value="{{ old('city',$firm->city) }}" placeholder="Miasto" required style="width:100%;padding:12px;margin-bottom:10px">
<input name="address" value="{{ old('address',$firm->address) }}" placeholder="Adres" required style="width:100%;padding:12px;margin-bottom:10px">
<input name="phone" value="{{ old('phone',$firm->phone) }}" placeholder="Telefon" style="width:100%;padding:12px;margin-bottom:20px">

<hr>

{{-- 🎁 PROMOCJA --}}
<h4>🎁 Warunki promocji / nagroda</h4>
<textarea name="promotion_text"
          rows="4"
          placeholder="Np. 10 bukietów = 1 gratis"
          style="width:100%;padding:12px;margin-bottom:20px">{{ old('promotion_text',$firm->promotion_text) }}</textarea>

{{-- 🕒 GODZINY OTWARCIA --}}
<h4>🕒 Godziny otwarcia</h4>
<textarea name="opening_hours"
          rows="3"
          placeholder="Pon–Pt 8:00–18:00&#10;Sobota 9:00–14:00"
          style="width:100%;padding:12px;margin-bottom:20px">{{ old('opening_hours',$firm->opening_hours) }}</textarea>

<hr>

{{-- 🌍 SOCIAL MEDIA --}}
<h4>🌍 Social Media</h4>
<input name="facebook_url"
       value="{{ old('facebook_url',$firm->facebook_url) }}"
       placeholder="Link do Facebook"
       style="width:100%;padding:12px;margin-bottom:10px">

<input name="instagram_url"
       value="{{ old('instagram_url',$firm->instagram_url) }}"
       placeholder="Link do Instagram"
       style="width:100%;padding:12px;margin-bottom:10px">

<input name="youtube_url"
       value="{{ old('youtube_url',$firm->youtube_url) }}"
       placeholder="Link do YouTube"
       style="width:100%;padding:12px;margin-bottom:20px">

<hr>

{{-- GOOGLE --}}
<h4>⭐ Wizytówka Google</h4>
<input name="google_url"
       value="{{ old('google_url',$firm->google_url) }}"
       placeholder="Link do opinii Google"
       style="width:100%;padding:12px;margin-bottom:20px">

<hr>

{{-- LOGO --}}
<h4>🖼 Logo</h4>
<input type="file"
       name="logo"
       accept="image/*"
       style="width:100%;padding:12px;margin-bottom:30px">

<button type="submit" style="
    width:100%;
    padding:14px;
    border:none;
    border-radius:14px;
    font-size:16px;
    font-weight:700;
    color:#fff;
    background:linear-gradient(135deg,#6a5af9,#ff5fa2);
">
💾 Zapisz zmiany
</button>

<div style="margin-top:16px;text-align:center;">
    <a href="{{ route('admin.firms.index') }}" style="color:#666;text-decoration:none;font-weight:600;">
        ← Wróć do listy firm
    </a>
</div>

</form>
</div>
@endsection
