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
.sticker{font-size:30px;opacity:.25;transition:.3s;}
.sticker.active{opacity:1;filter:drop-shadow(0 0 6px rgba(236,72,153,.6));}
.sticker.success{animation:celebrate 1.2s infinite;}
@keyframes celebrate{0%{transform:scale(1);}50%{transform:scale(1.15);}100%{transform:scale(1);}}

.central-motivation{
margin:14px 0 20px;
padding:14px;
border-radius:18px;
background:linear-gradient(90deg,#ec4899,#db2777);
color:#fff;
font-weight:800;
font-size:.95rem;
}
.central-motivation.success{
background:linear-gradient(90deg,#22c55e,#16a34a);
box-shadow:0 0 20px rgba(34,197,94,.45);
}
.central-sub{margin-top:6px;font-size:.82rem;opacity:.95;font-weight:500;}

.qr-section svg{width:150px;height:150px;}
.code-number{font-size:1.6rem;font-weight:800;letter-spacing:2px;margin-top:6px;}

.glass-box{background:rgba(255,255,255,.22);backdrop-filter:blur(10px);border-radius:26px;padding:16px;color:#fff;margin-bottom:14px;}
details summary{cursor:pointer;font-weight:800;list-style:none;display:flex;align-items:center;justify-content:center;gap:8px;}
details summary::before{content:"▶";transition:.2s;}
details[open] summary::before{transform:rotate(90deg);}
details summary::-webkit-details-marker{display:none;}
details > div{text-align:center;margin-top:14px;font-size:1rem;line-height:1.6;}

.contact-row{margin-bottom:8px;font-weight:600;}

.progress-bar-wrapper{width:100%;height:10px;background:rgba(255,255,255,.35);border-radius:999px;margin-top:12px;overflow:hidden;}
.progress-bar{height:100%;background:linear-gradient(90deg,#ec4899,#be185d);border-radius:999px;transition:width .6s ease;}
.progress-bar.full{background:linear-gradient(90deg,#22c55e,#16a34a);}

.social-icons{display:flex;justify-content:center;gap:18px;margin-top:10px;}
.social-icons a{
width:46px;height:46px;display:flex;align-items:center;justify-content:center;
border-radius:50%;background:rgba(255,255,255,.18);
transition:.25s;backdrop-filter:blur(6px);
}
.social-icons a:hover{
background:#fff;transform:translateY(-3px);
box-shadow:0 8px 18px rgba(0,0,0,.2);
}
.social-icons svg{width:22px;height:22px;fill:#ffffff;transition:.2s;}
.social-icons a:hover svg{fill:#ec4899;}

.google-btn{
display:inline-block;
padding:8px 18px;
border-radius:999px;
background:#ffffff;
color:#ec4899;
font-weight:800;
text-decoration:none;
font-size:.9rem;
transition:.25s;
box-shadow:0 6px 18px rgba(0,0,0,.15);
}
.google-btn:hover{
transform:translateY(-3px);
box-shadow:0 10px 22px rgba(0,0,0,.2);
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

@php
$percent = ($maxStamps ?? 0) > 0 ? (int) round(($current / $maxStamps) * 100) : 0;
$remaining = max(0, (int)$maxStamps - (int)$current);

function bukietOdmiana($liczba){
if($liczba == 1) return 'bukiet';
if($liczba % 10 >= 2 && $liczba % 10 <= 4 && !($liczba % 100 >= 12 && $liczba % 100 <= 14)) return 'bukiety';
return 'bukietów';
}

$google = $firm->google_url;
$fb = $firm->facebook_url;
$ig = $firm->instagram_url;
$yt = $firm->youtube_url;
@endphp

<div class="card">
<h1>{{ $firm->name }}</h1>
<div class="subtitle">Karta lojalnościowa kwiaciarni</div>

<div class="stickers-grid">
@for($i=1;$i<=$maxStamps;$i++)
<div class="sticker {{ $i <= $current ? ($percent===100 ? 'active success' : 'active') : '' }}">💐</div>
@endfor
</div>

<div class="central-motivation {{ $percent===100 ? 'success' : '' }}">
@if($percent === 100)
🎉 GRATULACJE!
<div class="central-sub">Odbierz swój darmowy bukiet przy kasie 🌸</div>
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
<details>
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

{{-- 📍 DANE --}}
@if($firm->address || $firm->city || $firm->phone)
<div class="glass-box">
<details>
<summary>📍 Dane kontaktowe</summary>
<div>
@if($firm->address)<div class="contact-row">📍 {{ $firm->address }}</div>@endif
@if($firm->postal_code || $firm->city)<div class="contact-row">🏙 {{ $firm->postal_code }} {{ $firm->city }}</div>@endif
@if($firm->phone)<div class="contact-row">📞 {{ $firm->phone }}</div>@endif
</div>
</details>
</div>
@endif

{{-- ⭐ GOOGLE --}}
@if($google)
<div class="glass-box">
<details>
<summary>⭐ Opinie Google</summary>
<div>
<a class="google-btn"
href="{{ \Illuminate\Support\Str::startsWith($google, ['http://','https://']) ? $google : 'https://'.$google }}"
target="_blank" rel="noopener">
⭐ Zobacz / dodaj opinię
</a>
</div>
</details>
</div>
@endif

{{-- 🌍 SOCIAL --}}
@if($fb || $ig || $yt)
<div class="glass-box">
<details>
<summary>🌍 Social Media</summary>
<div class="social-icons">

@if($fb)
<a href="{{ \Illuminate\Support\Str::startsWith($fb, ['http://','https://']) ? $fb : 'https://'.$fb }}" target="_blank">
<svg viewBox="0 0 24 24"><path d="M22 12a10 10 0 10-11.5 9.9v-7H8v-3h2.5V9.5c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.3.2 2.3.2v2.5h-1.3c-1.3 0-1.7.8-1.7 1.6V12H17l-.4 3h-2.5v7A10 10 0 0022 12z"/></svg>
</a>
@endif

@if($ig)
<a href="{{ \Illuminate\Support\Str::startsWith($ig, ['http://','https://']) ? $ig : 'https://'.$ig }}" target="_blank">
<svg viewBox="0 0 24 24"><path d="M7 2C4.2 2 2 4.2 2 7v10c0 2.8 2.2 5 5 5h10c2.8 0 5-2.2 5-5V7c0-2.8-2.2-5-5-5H7zm5 5a5 5 0 110 10 5 5 0 010-10zm6-1.2a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4zM12 9a3 3 0 100 6 3 3 0 000-6z"/></svg>
</a>
@endif

@if($yt)
<a href="{{ \Illuminate\Support\Str::startsWith($yt, ['http://','https://']) ? $yt : 'https://'.$yt }}" target="_blank">
<svg viewBox="0 0 24 24"><path d="M23 12s0-3.5-.4-5.2a3 3 0 00-2.1-2.1C18.8 4 12 4 12 4s-6.8 0-8.5.7A3 3 0 001.4 6.8C1 8.5 1 12 1 12s0 3.5.4 5.2a3 3 0 002.1 2.1C5.2 20 12 20 12 20s6.8 0 8.5-.7a3 3 0 002.1-2.1C23 15.5 23 12 23 12zM10 15.5v-7l6 3.5-6 3.5z"/></svg>
</a>
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

{{-- 🔔 RODO --}}
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
