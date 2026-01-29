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
{{-- 📊 STATYSTYKI FIRMY --}}
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
        <div style="font-size:13px;color:#6b7280;">Karty lojalnościowe</div>
        <div style="font-size:26px;font-weight:800;">{{ $cardsCount }}</div>
    </div>

    <div style="background:#f9fafb;padding:16px;border-radius:14px;">
        <div style="font-size:13px;color:#6b7280;">Klienci</div>
        <div style="font-size:26px;font-weight:800;">{{ $clientsCount }}</div>
    </div>

</div>
    <div style="margin-bottom:20px;">
        <h2 style="margin-bottom:6px;">✏️ Edycja firmy</h2>
        <p style="color:#666;margin:0;">
            ID: <b>{{ $firm->id }}</b> · slug: <b>{{ $firm->slug }}</b>
        </p>
    </div>

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

    <form method="POST"
          action="{{ route('admin.firms.update', $firm) }}"
          enctype="multipart/form-data">
        @csrf
<form method="POST"
      action="{{ route('admin.firms.update', $firm) }}"
      enctype="multipart/form-data">
    @csrf
    @method('PUT')
        {{-- PODSTAWOWE DANE --}}
        <h4 style="margin-bottom:10px;">🏢 Dane firmy</h4>

        <input name="name" value="{{ old('name', $firm->name) }}" placeholder="Nazwa firmy" required
               style="width:100%;padding:12px;margin-bottom:10px">

        <input name="city" value="{{ old('city', $firm->city) }}" placeholder="Miasto" required
               style="width:100%;padding:12px;margin-bottom:10px">

        <input name="address" value="{{ old('address', $firm->address) }}" placeholder="Adres" required
               style="width:100%;padding:12px;margin-bottom:10px">

        <input name="phone" value="{{ old('phone', $firm->phone) }}" placeholder="Telefon"
               style="width:100%;padding:12px;margin-bottom:20px">

        <hr style="margin:24px 0">

        {{-- LOGO --}}
        <h4 style="margin-bottom:10px;">🖼 Logo firmy</h4>

        <div style="display:flex;align-items:center;gap:20px;margin-bottom:16px;">
            <div style="
                width:160px;
                height:120px;
                border-radius:18px;
                background:#ffffff;
                border:1px dashed #e5e7eb;
                display:flex;
                align-items:center;
                justify-content:center;
                overflow:hidden;
                padding:12px;
            ">
                @if($firm->logo_path)
                    <img
                        src="{{ asset('storage/'.$firm->logo_path) }}"
                        alt="logo"
                        style="
                            width:100%;
                            height:100%;
                            object-fit:contain;
                        "
                    >
                @else
                    <span style="font-size:34px;opacity:.4;">🏷️</span>
                @endif
            </div>

            <div style="flex:1;color:#555;font-size:14px;line-height:1.4;">
                @if($firm->logo_path)
                    Logo wyświetlane na pełnej szerokości boxa  
                @else
                    Brak logo – dodaj plik (najlepiej PNG/JPG na białym tle)
                @endif
            </div>
        </div>

        <input type="file" name="logo" accept="image/*"
               style="width:100%;padding:12px;margin-bottom:20px">

        <hr style="margin:24px 0">

        {{-- SZABLON --}}
        <h4 style="margin-bottom:10px;">🎨 Szablon karty</h4>

        <select name="card_template" style="width:100%;padding:12px;margin-bottom:20px">
            @foreach(['classic','modern','elegant','gold','florist'] as $tpl)
                <option value="{{ $tpl }}"
                    @selected(old('card_template', $firm->card_template) === $tpl)>
                    {{ ucfirst($tpl) }}
                </option>
            @endforeach
        </select>

        <hr style="margin:24px 0">

        {{-- GOOGLE --}}
        <h4 style="margin-bottom:10px;">⭐ Wizytówka Google (opinie)</h4>

        <input name="google_url"
               value="{{ old('google_url', $firm->google_url) }}"
               placeholder="Link do wizytówki Google"
               style="width:100%;padding:12px;margin-bottom:24px">

        <button type="submit"
                style="
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
            <a href="{{ route('admin.firms.index') }}"
               style="color:#666;text-decoration:none;font-weight:600;">
                ← Wróć do listy firm
            </a>
        </div>

    </form>
</div>
@endsection
