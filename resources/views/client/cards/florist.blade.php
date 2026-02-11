<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">

<title>{{ $firm->name ?? 'Karta lojalnościowa' }} – Looply</title>

<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

<link rel="icon" type="image/png" href="/favicon.png">
<link rel="shortcut icon" href="/favicon.png">

<link rel="manifest" href="/manifest.json">
<meta name="theme-color" content="#f472b6">

<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="{{ $firm->name ?? 'Looply' }}">
<link rel="apple-touch-icon" href="/icons/icon-192.png">

<style>
*{box-sizing:border-box;margin:0;padding:0;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,sans-serif;}
body{min-height:100vh;background:linear-gradient(180deg,#fbcfe8 0%,#f9a8d4 50%,#f472b6 100%);display:flex;justify-content:center;align-items:flex-start;padding:20px 16px 40px;}
.container{width:100%;max-width:400px;}
.logo-section{width:100%;background:rgba(255,255,255,.35);border-radius:28px;padding:18px;margin-bottom:12px;display:flex;justify-content:center;}
.logo-section img{max-width:100%;max-height:90px;object-fit:contain;}
.card{background:#fff;border-radius:32px;padding:28px 20px;box-shadow:0 25px 60px rgba(0,0,0,.25);margin-bottom:16px;text-align:center;}
.subtitle{color:#888;font-size:.9rem;margin:6px 0 18px;border-bottom:1px solid #eee;padding-bottom:16px;}
.stickers-grid{display:grid;grid-template-columns:repeat(5,1fr);gap:12px;margin:0 auto 18px;}
.sticker{font-size:30px;opacity:.25;}
.sticker.active{opacity:1;filter:drop-shadow(0 0 6px rgba(236,72,153,.6));}
.qr-section svg{width:150px;height:150px;}
.code-number{font-size:1.6rem;font-weight:800;letter-spacing:2px;margin-top:6px;}
.glass-box{background:rgba(255,255,255,.22);backdrop-filter:blur(10px);border-radius:26px;padding:16px;color:#fff;margin-bottom:14px;}
details summary{cursor:pointer;font-weight:700;list-style:none;display:flex;align-items:center;justify-content:center;gap:8px;}
details summary::before{content:"▶";transition:.2s;}
details[open] summary::before{transform:rotate(90deg);}
details summary::-webkit-details-marker{display:none;}
details > div{text-align:center;margin-top:12px;font-size:.9rem;line-height:1.5;}

.progress-bar-wrapper{
    width:100%;
    height:8px;
    background:rgba(255,255,255,.35);
    border-radius:999px;
    margin-top:12px;
    overflow:hidden;
}

.progress-bar{
    height:100%;
    background:linear-gradient(90deg,#ec4899,#be185d);
    border-radius:999px;
    transition:width .6s ease;
}

.social-icons{
    display:flex;
    justify-content:center;
    gap:18px;
    margin-top:10px;
}

.social-icons a{
    width:36px;
    height:36px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:50%;
    background:rgba(255,255,255,.3);
    transition:.2s;
}

.social-icons a:hover{
    background:#fff;
}
.social-icons svg{
    width:18px;
    height:18px;
}
</style>
</head>

<body>
<div class="container">

<div class="logo-section">
    @if($firm->logo_path)
        <img src="{{ asset('storage/'.$firm->logo_path) }}" alt="{{ $firm->name }}">
    @else
        <span style="font-size:48px">💐</span>
    @endif
</div>

<div class="card">
    <h1>{{ $firm->name }}</h1>
    <div class="subtitle">Karta lojalnościowa kwiaciarni</div>

    <div class="stickers-grid">
        @for($i=1;$i<=$maxStamps;$i++)
            <div class="sticker {{ $i <= $current ? 'active' : '' }}">💐</div>
        @endfor
    </div>

    <div class="qr-section">
        {!! $qr !!}
        <div class="code-number">{{ $displayCode }}</div>
    </div>
</div>

{{-- 🎁 PROMOCJA --}}
@if($firm->promotion_text)
<div class="glass-box">
<details>
<summary>🎁 Nagroda / Promocja</summary>
<div>{!! nl2br(e($firm->promotion_text)) !!}</div>
</details>
</div>
@endif

{{-- 📍 DANE --}}
@if($firm->address || $firm->city || $firm->phone)
<div class="glass-box">
<details>
<summary>📍 Dane kontaktowe</summary>
<div>
@if($firm->address) {{ $firm->address }}<br>@endif
@if($firm->postal_code || $firm->city) {{ $firm->postal_code }} {{ $firm->city }}<br>@endif
@if($firm->phone) 📞 {{ $firm->phone }} @endif
</div>
</details>
</div>
@endif

{{-- 🕒 GODZINY --}}
@if($firm->opening_hours)
<div class="glass-box">
<details>
<summary>🕒 Godziny otwarcia</summary>
<div>{!! nl2br(e($firm->opening_hours)) !!}</div>
</details>
</div>
@endif

{{-- 🌍 SOCIAL --}}
@if($firm->facebook_url || $firm->instagram_url || $firm->youtube_url)
<div class="glass-box">
<details>
<summary>🌍 Social Media</summary>
<div class="social-icons">

@if($firm->facebook_url)
<a href="{{ $firm->facebook_url }}" target="_blank">
<svg fill="#1877F2" viewBox="0 0 24 24"><path d="M22 12a10 10 0 1 0-11.5 9.9v-7H8v-3h2.5V9.5c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.3.2 2.3.2v2.5h-1.3c-1.3 0-1.7.8-1.7 1.6V12H17l-.4 3h-2.5v7A10 10 0 0 0 22 12z"/></svg>
</a>
@endif

@if($firm->instagram_url)
<a href="{{ $firm->instagram_url }}" target="_blank">
<svg fill="#E1306C" viewBox="0 0 24 24"><path d="M7 2C4 2 2 4 2 7v10c0 3 2 5 5 5h10c3 0 5-2 5-5V7c0-3-2-5-5-5H7zm5 5a5 5 0 1 1 0 10 5 5 0 0 1 0-10zm6-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/></svg>
</a>
@endif

@if($firm->youtube_url)
<a href="{{ $firm->youtube_url }}" target="_blank">
<svg fill="#FF0000" viewBox="0 0 24 24"><path d="M21.8 8s-.2-1.4-.8-2a2.9 2.9 0 0 0-2-1C16.2 4.5 12 4.5 12 4.5h0s-4.2 0-7 .5a2.9 2.9 0 0 0-2 1c-.6.6-.8 2-.8 2S2 9.6 2 11.3v1.4C2 14.4 2.2 16 2.2 16s.2 1.4.8 2a2.9 2.9 0 0 0 2 1c2.8.5 7 .5 7 .5s4.2 0 7-.5a2.9 2.9 0 0 0 2-1c.6-.6.8-2 .8-2s.2-1.6.2-3.3v-1.4C22 9.6 21.8 8 21.8 8zM10 14.5v-5l5 2.5-5 2.5z"/></svg>
</a>
@endif

</div>
</details>
</div>
@endif

{{-- ⭐ GOOGLE --}}
@if($firm->google_url)
<div class="glass-box">
<details>
<summary>⭐ Opinie Google</summary>
<div>
<a href="{{ $firm->google_url }}" target="_blank" style="display:inline-block;padding:10px 18px;border-radius:999px;background:#fbbc05;color:#000;font-weight:700;text-decoration:none;">
⭐ Zobacz / dodaj opinię
</a>
</div>
</details>
</div>
@endif

{{-- 📊 POSTĘP --}}
@php $percent = $maxStamps > 0 ? round(($current / $maxStamps) * 100) : 0; @endphp
<div class="glass-box">
<details open>
<summary>📊 Postęp karty</summary>
<div>
Masz <strong>{{ $current }}</strong> / {{ $maxStamps }} bukietów
<div class="progress-bar-wrapper">
    <div class="progress-bar" style="width: {{ $percent }}%;"></div>
</div>
</div>
</details>
</div>

{{-- 🔔 ZGODY --}}
<div class="glass-box">
<details>
<summary>🔔 Zgody marketingowe i RODO</summary>
<div>
@if($client->sms_marketing_consent)
✅ Zgoda na SMS marketing<br>
<small>{{ $client->sms_marketing_consent_at?->format('d.m.Y H:i') }}</small>
@else
❌ Brak zgody na SMS marketing
@endif
<hr style="margin:12px 0;opacity:.3;">
<small>{{ $client->terms_accepted_at?->format('d.m.Y H:i') }}</small>
</div>
</details>
</div>

</div>
</body>
</html>
