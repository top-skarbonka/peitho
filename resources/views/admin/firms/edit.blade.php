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

{{-- 🖼 LOGO --}}
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
💾 Zapisz zmiany firmy
</button>

</form>

<hr style="margin:40px 0;">

{{-- 🔥 PROMOCJE --}}
<h4>🔥 Promocje</h4>

@if($promotions->isEmpty())
<div style="background:#f9fafb;padding:14px;border-radius:12px;margin-bottom:20px;">
    Brak promocji
</div>
@else
    @foreach($promotions as $promotion)
    <div style="background:#f9fafb;padding:14px;border-radius:12px;margin-bottom:10px;">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:12px;">
            <div style="flex:1;">
                <strong>{{ $promotion->title }}</strong><br>

                @if($promotion->promo_text)
                    <div style="margin-top:6px;">{{ $promotion->promo_text }}</div>
                @endif

                @if($promotion->image_path)
                    <div style="margin-top:10px;">
                        <img src="{{ asset('storage/'.$promotion->image_path) }}" style="max-width:120px;border-radius:8px;">
                    </div>
                @endif

                <div style="margin-top:8px;font-size:13px;color:#6b7280;">
                    Status: {{ $promotion->is_active ? 'Aktywna' : 'Nieaktywna' }}
                    @if(!is_null($promotion->sort_order))
                        | Kolejność: {{ $promotion->sort_order }}
                    @endif
                </div>
            </div>

            <form method="POST"
                  action="{{ route('admin.firms.promotions.destroy', [$firm, $promotion]) }}"
                  onsubmit="return confirm('Na pewno usunąć tę promocję?');">
                @csrf
                @method('DELETE')
                <button type="submit" style="
                    border:none;
                    background:#dc2626;
                    color:#fff;
                    border-radius:10px;
                    padding:8px 10px;
                    font-weight:700;
                    cursor:pointer;
                ">
                    🗑
                </button>
            </form>
        </div>
    </div>
    @endforeach
@endif

<form method="POST"
      action="{{ route('admin.firms.promotions.store', $firm) }}"
      enctype="multipart/form-data"
      style="background:#fff;border:2px dashed #ddd;padding:16px;border-radius:12px;margin-top:20px;margin-bottom:30px;">
    @csrf

    <h5 style="margin-top:0;">➕ Dodaj promocję</h5>

    <input name="title"
           placeholder="Tytuł (np. Kawa -20%)"
           required
           style="width:100%;padding:10px;margin-bottom:10px">

    <input name="promo_text"
           placeholder="Opis (np. tylko dziś)"
           style="width:100%;padding:10px;margin-bottom:10px">

    <input type="file"
           name="image"
           accept="image/*"
           style="margin-bottom:10px">

    <label style="display:block;margin-bottom:10px;">
        <input type="checkbox" name="is_active" value="1" checked>
        Aktywna
    </label>

    <input name="sort_order"
           placeholder="Kolejność (np. 1)"
           style="width:100%;padding:10px;margin-bottom:10px">

    <button type="submit" style="
        width:100%;
        padding:10px;
        border:none;
        border-radius:10px;
        background:#111;
        color:#fff;
        font-weight:700;
    ">
        ➕ Dodaj promocję
    </button>
</form>

<hr>

{{-- 📍 LOKALIZACJE --}}
<h4>📍 Lokalizacje</h4>

@if($locations->isEmpty())
<div style="background:#f9fafb;padding:14px;border-radius:12px;margin-bottom:20px;">
    Brak lokalizacji dodatkowych
</div>
@else
    @foreach($locations as $location)
    <div style="background:#f9fafb;padding:14px;border-radius:12px;margin-bottom:10px;">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:12px;">
            <div style="flex:1;">
                <strong>{{ $location->name ?: 'Lokalizacja' }}</strong><br>
                {{ $location->address }}
                @if($location->city)
                    , {{ $location->city }}
                @endif
                @if($location->postal_code)
                    , {{ $location->postal_code }}
                @endif

                <div style="margin-top:8px;font-size:13px;color:#6b7280;">
                    Status: {{ $location->is_active ? 'Aktywna' : 'Nieaktywna' }}
                    @if(!is_null($location->sort_order))
                        | Kolejność: {{ $location->sort_order }}
                    @endif
                </div>

                @if($location->google_maps_url)
                <div style="margin-top:8px;">
                    <a href="{{ $location->google_maps_url }}" target="_blank" style="color:#2563eb;text-decoration:none;font-weight:600;">
                        Otwórz Google Maps
                    </a>
                </div>
                @endif
            </div>

            <form method="POST"
                  action="{{ route('admin.firms.locations.destroy', [$firm, $location]) }}"
                  onsubmit="return confirm('Na pewno usunąć tę lokalizację?');">
                @csrf
                @method('DELETE')
                <button type="submit" style="
                    border:none;
                    background:#dc2626;
                    color:#fff;
                    border-radius:10px;
                    padding:8px 10px;
                    font-weight:700;
                    cursor:pointer;
                ">
                    🗑
                </button>
            </form>
        </div>
    </div>
    @endforeach
@endif

<form method="POST"
      action="{{ route('admin.firms.locations.store', $firm) }}"
      style="background:#fff;border:2px dashed #ddd;padding:16px;border-radius:12px;margin-top:20px;">
    @csrf

    <h5 style="margin-top:0;">➕ Dodaj lokalizację</h5>

    <input name="name"
           placeholder="Nazwa lokalizacji (np. Punkt 1)"
           style="width:100%;padding:10px;margin-bottom:10px">

    <input name="address"
           placeholder="Adres"
           required
           style="width:100%;padding:10px;margin-bottom:10px">

    <input name="city"
           placeholder="Miasto"
           style="width:100%;padding:10px;margin-bottom:10px">

    <input name="postal_code"
           placeholder="Kod pocztowy"
           style="width:100%;padding:10px;margin-bottom:10px">

    <input name="google_maps_url"
           placeholder="Link do Google Maps"
           style="width:100%;padding:10px;margin-bottom:10px">

    <input name="latitude"
           placeholder="Szerokość geograficzna (latitude)"
           style="width:100%;padding:10px;margin-bottom:10px">

    <input name="longitude"
           placeholder="Długość geograficzna (longitude)"
           style="width:100%;padding:10px;margin-bottom:10px">

    <label style="display:block;margin-bottom:10px;">
        <input type="checkbox" name="is_active" value="1" checked>
        Aktywna
    </label>

    <input name="sort_order"
           placeholder="Kolejność (np. 1)"
           style="width:100%;padding:10px;margin-bottom:10px">

    <button type="submit" style="
        width:100%;
        padding:10px;
        border:none;
        border-radius:10px;
        background:#111;
        color:#fff;
        font-weight:700;
    ">
        ➕ Dodaj lokalizację
    </button>
</form>

<hr>

{{-- 🤝 POLECANE FIRMY --}}
<h4>🤝 Polecane firmy</h4>

@if($recommendations->isEmpty())
<div style="background:#f9fafb;padding:14px;border-radius:12px;margin-bottom:20px;">
    Brak polecanych firm
</div>
@else
    @foreach($recommendations as $recommendation)
    <div style="background:#f9fafb;padding:14px;border-radius:12px;margin-bottom:10px;">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:12px;">
            <div style="flex:1;">
                <strong>
                    {{ $recommendation->recommendedFirm->name ?? 'Brak firmy' }}
                </strong><br>

                <div style="margin-top:6px;font-size:14px;color:#4b5563;">
                    Kategoria:
                    <strong>{{ $recommendation->category->name ?? 'Brak kategorii' }}</strong>
                </div>

                @if($recommendation->promo_text)
                    <div style="margin-top:6px;">{{ $recommendation->promo_text }}</div>
                @endif

                <div style="margin-top:8px;font-size:13px;color:#6b7280;">
                    @if(!is_null($recommendation->sort_order))
                        Kolejność: {{ $recommendation->sort_order }}
                    @endif
                </div>
            </div>

            <form method="POST"
                  action="{{ route('admin.firms.recommendations.destroy', [$firm, $recommendation]) }}"
                  onsubmit="return confirm('Na pewno usunąć polecaną firmę?');">
                @csrf
                @method('DELETE')
                <button type="submit" style="
                    border:none;
                    background:#dc2626;
                    color:#fff;
                    border-radius:10px;
                    padding:8px 10px;
                    font-weight:700;
                    cursor:pointer;
                ">
                    🗑
                </button>
            </form>
        </div>
    </div>
    @endforeach
@endif

<form method="POST"
      action="{{ route('admin.firms.recommendations.store', $firm) }}"
      style="background:#fff;border:2px dashed #ddd;padding:16px;border-radius:12px;margin-top:20px;">
    @csrf

    <h5 style="margin-top:0;">➕ Dodaj polecaną firmę</h5>

    <select name="category_id"
            required
            style="width:100%;padding:10px;margin-bottom:10px">
        <option value="">Wybierz kategorię</option>
        @foreach($recommendationCategories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>

    <select name="recommended_firm_id"
            required
            style="width:100%;padding:10px;margin-bottom:10px">
        <option value="">Wybierz firmę</option>
        @foreach($allFirms as $recommendedFirm)
            @if($recommendedFirm->id !== $firm->id)
                <option value="{{ $recommendedFirm->id }}">{{ $recommendedFirm->name }}</option>
            @endif
        @endforeach
    </select>

    <input name="promo_text"
           placeholder="Hasło promo (np. -15% dla klientów Looply)"
           style="width:100%;padding:10px;margin-bottom:10px">

    <input name="sort_order"
           placeholder="Kolejność (np. 1)"
           style="width:100%;padding:10px;margin-bottom:10px">

    <button type="submit" style="
        width:100%;
        padding:10px;
        border:none;
        border-radius:10px;
        background:#111;
        color:#fff;
        font-weight:700;
    ">
        ➕ Dodaj polecaną firmę
    </button>
</form>

<div style="margin-top:16px;text-align:center;">
    <a href="{{ route('admin.firms.index') }}" style="color:#666;text-decoration:none;font-weight:600;">
        ← Wróć do listy firm
    </a>
</div>

</div>
@endsection
