<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<title>{{ $firm->name ?? 'Karta lojalnościowa' }} – Looply</title>
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

<link rel="icon" type="image/png" href="/favicon.png">
<link rel="manifest" href="/manifest.json">
<meta name="theme-color" content="#f472b6">

<style>
*{box-sizing:border-box;margin:0;padding:0;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,sans-serif;}
body{min-height:100vh;background:linear-gradient(180deg,#fbcfe8 0%,#f9a8d4 50%,#f472b6 100%);display:flex;justify-content:center;align-items:flex-start;padding:20px 16px 40px;}
.container{width:100%;max-width:400px;}
.logo-section{width:100%;background:rgba(255,255,255,.35);border-radius:28px;padding:18px;margin-bottom:12px;display:flex;justify-content:center;}
.card{background:#fff;border-radius:32px;padding:28px 20px;box-shadow:0 25px 60px rgba(0,0,0,.25);margin-bottom:16px;text-align:center;}
.subtitle{color:#888;font-size:.9rem;margin:6px 0 18px;border-bottom:1px solid #eee;padding-bottom:16px;}

.stickers-grid{display:grid;grid-template-columns:repeat(5,1fr);gap:12px;margin:0 auto 18px;}
.sticker{font-size:30px;opacity:.25;}
.sticker.active{opacity:1;filter:drop-shadow(0 0 6px rgba(236,72,153,.6));}

.central-motivation{
margin:14px 0 20px;
padding:14px;
border-radius:18px;
background:linear-gradient(90deg,#ec4899,#db2777);
color:#fff;
font-weight:800;
font-size:.95rem;
}

.central-sub{
margin-top:6px;
font-size:.82rem;
opacity:.9;
font-weight:500;
}

.qr-section svg{width:150px;height:150px;}
.code-number{font-size:1.6rem;font-weight:800;letter-spacing:2px;margin-top:6px;}

.glass-box{background:rgba(255,255,255,.22);backdrop-filter:blur(10px);border-radius:26px;padding:16px;color:#fff;margin-bottom:14px;}
details summary{cursor:pointer;font-weight:800;list-style:none;display:flex;align-items:center;justify-content:center;gap:8px;}
details summary::before{content:"▶";transition:.2s;}
details[open] summary::before{transform:rotate(90deg);}
details summary::-webkit-details-marker{display:none;}
details > div{text-align:center;margin-top:14px;font-size:1rem;line-height:1.6;}

.contact-row{
display:flex;
align-items:center;
justify-content:center;
gap:10px;
margin-bottom:8px;
font-weight:600;
}

.contact-row svg{width:20px;height:20px;flex-shrink:0;}

.progress-bar-wrapper{width:100%;height:10px;background:rgba(255,255,255,.35);border-radius:999px;margin-top:12px;overflow:hidden;}
.progress-bar{height:100%;background:linear-gradient(90deg,#ec4899,#be185d);border-radius:999px;transition:width .6s ease;}
.progress-bar.full{background:linear-gradient(90deg,#22c55e,#16a34a);}

.social-icons{display:flex;justify-content:center;gap:18px;margin-top:10px;}
.social-icons a{width:44px;height:44px;display:flex;align-items:center;justify-content:center;border-radius:50%;background:rgba(255,255,255,.28);transition:.2s;}
.social-icons a:hover{background:#fff;transform:translateY(-1px);}
.social-icons svg{width:22px;height:22px;display:block;}
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

@php
$percent = ($maxStamps ?? 0) > 0 ? (int) round(($current / $maxStamps) * 100) : 0;
$remaining = max(0, (int)$maxStamps - (int)$current);

function bukietOdmiana($liczba){
    if($liczba == 1) return 'bukiet';
    if($liczba % 10 >= 2 && $liczba % 10 <= 4 && !($liczba % 100 >= 12 && $liczba % 100 <= 14)) return 'bukiety';
    return 'bukietów';
}
@endphp

<div class="card">
<h1>{{ $firm->name }}</h1>
<div class="subtitle">Karta lojalnościowa kwiaciarni</div>

<div class="stickers-grid">
@for($i=1;$i<=$maxStamps;$i++)
<div class="sticker {{ $i <= $current ? 'active' : '' }}">💐</div>
@endfor
</div>

<div class="central-motivation">
@if($percent === 100)
🎉 Nagroda gotowa!
<div class="central-sub">Odbierz swój darmowy bukiet przy kasie.</div>
@elseif($remaining > 0)
💐 Jeszcze {{ $remaining }} {{ bukietOdmiana($remaining) }} i nagroda jest Twoja!
<div class="central-sub">Przy następnej wizycie będziesz jeszcze bliżej 🌸</div>
@endif
</div>

<div class="qr-section">
{!! $qr !!}
<div class="code-number">{{ $displayCode }}</div>
</div>
</div>

{{-- 📊 POSTĘP --}}
<div class="glass-box">
<details open>
<summary>📊 Postęp karty</summary>
<div>
Masz <strong>{{ $current }}</strong> / {{ $maxStamps }} bukietów
<div class="progress-bar-wrapper">
<div class="progress-bar {{ $percent === 100 ? 'full' : '' }}" style="width: {{ $percent }}%;"></div>
</div>
</div>
</details>
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

{{-- 📍 DANE KONTAKTOWE --}}
@if($firm->address || $firm->city || $firm->phone)
<div class="glass-box">
<details>
<summary>📍 Dane kontaktowe</summary>
<div>
@if($firm->address)
<div class="contact-row">
<svg viewBox="0 0 24 24"><path fill="#ffffff" d="M12 2C8 2 5 5 5 9c0 5.2 7 13 7 13s7-7.8 7-13c0-4-3-7-7-7z"/></svg>
<span>{{ $firm->address }}</span>
</div>
@endif

@if($firm->postal_code || $firm->city)
<div class="contact-row">
<svg viewBox="0 0 24 24"><path fill="#ffffff" d="M4 4h16v16H4z"/></svg>
<span>{{ $firm->postal_code }} {{ $firm->city }}</span>
</div>
@endif

@if($firm->phone)
<div class="contact-row">
<svg viewBox="0 0 24 24"><path fill="#ffffff" d="M6.6 10.8a15 15 0 006.6 6.6l2.2-2.2z"/></svg>
<span>{{ $firm->phone }}</span>
</div>
@endif
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

{{-- 🔔 ZGODY --}}
<div class="glass-box">
<details>
<summary>🔔 Zgody marketingowe i RODO</summary>
<div>
@if($client->sms_marketing_consent)
✅ Zgoda na SMS marketing
@else
❌ Brak zgody na SMS marketing
@endif
</div>
</details>
</div>

</div>
</body>
</html>
